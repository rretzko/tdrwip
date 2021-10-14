<?php

namespace App\Models;

use App\Models\Utility\Fileviewport;
use App\Traits\RegistranttypeBackgroundColorsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    use HasFactory;

    protected $fillable = ['eventversion_id', 'id', 'programname', 'registranttype_id', 'school_id', 'user_id'];

    protected $with = ['student','instrumentations'];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function due()
    {
        return $this->eventversion->eventversionconfigs->registrationfee - $this->paid();
    }

    public function eapplication()
    {
        return $this->hasOne(Eapplication::class);
    }

    public function eventversion()
    {
        return $this->belongsTo(Eventversion::class);
    }

    public function fileuploads()
    {
        return $this->hasMany(Fileupload::class);
    }

    public function fileuploadapprovaltimestamp($filecontenttype) : string
    {
        return Carbon::parse(Fileupload::where('registrant_id', $this->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->first()
            ->approved)
            ->format('M d, Y g:i a');
    }

    public function fileuploadapproved($filecontenttype) : bool
    {
        return (bool)Fileupload::where('registrant_id', $this->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->first()
            ->approved;
    }

    /**
     * Return the embed code for the requested videotype
     *
     * NOTE: self::hasVideoType($videotype) should be run BEFORE this function.
     *
     * @param Videotype $videotype
     * @return string
     */
    public function fileviewport(Filecontenttype $filecontenttype)
    {
        $viewport = new Fileviewport($this,$filecontenttype);

        return $viewport->viewport();
    }

    public function adjudicatedStatus(\App\Models\Room $room)
    {
        $status = new \App\Models\Utility\AdjudicatedstatusRoom(['registrant' => $this, 'room' => $room]);

        return $status->status();
    }

    public function adjudicationStatusBackgroundColor(\App\Models\Room $room)
    {
        $colors = [
            'completed' => 'bg-green-100',
            'error' => 'bg-gray-100',
            'excess' => 'bg-blue-100',
            'partial' => 'bg-yellow-100',
            'tolerance' => 'bg-red-100',
            'unauditioned' => 'bg-white',
        ];

        return $colors[$this->adjudicatedStatus($room)];
    }

    public function getFilesApprovedCountAttribute(): int
    {
        return $this->fileuploads->whereNotNull('approved')->count();
    }

    public function getFilesApprovedDescrCSVAttribute(): string
    {
        $files = [];

        foreach($this->fileuploads->whereNotNull('approved') AS $fileupload){

            $files[] = $fileupload->filecontenttypeDescr;
        }

        return implode(',',$files);
    }

    public function getFilesUploadedDescrCSVAttribute(): string
    {
        $files = [];

        foreach($this->fileuploads AS $fileupload){

            $files[] = $fileupload->filecontenttypeDescr;
        }

        return implode(',',$files);
    }

    public function getHasApplicationAttribute(): bool
    {
        return (bool)Application::where('registrant_id', $this->id)->first();
    }

    public function getHasFileuploadsAttribute(): bool
    {
        $eventversion = Eventversion::find(Userconfig::getValue('eventversion',auth()->id()));
        $fileuploadtypescount = $eventversion->filecontenttypes->count();

        return $fileuploadtypescount === $this->filesApprovedCount;
    }

    public function getHasInstrumentationAttribute(): bool
    {
        return (bool)$this->instrumentations;
    }

    public function getHasSignaturesAttribute() : bool
    {
        if($this->eventversion->eventversionconfigs->eapplication && $this->eapplication){
            $cntr = 0;

            $cntr += $this->eapplication->signatureguardian;
            $cntr += $this->eapplication->signaturestudent;

            return $cntr === 2;
        }

        return ($this->signatures->whereNotNull('confirmed')->count() === Signaturetype::all()->count());
    }

    public function getInstrumentationsCSVAttribute()
    {
        $descrs = [];

        foreach($this->instrumentations AS $instrumentation){
            $descrs[] = $instrumentation->abbr;
        }

        return ($descrs) ? implode(',',$descrs) : 'None found';
    }

    public function getRegistranttypeDescrAttribute()
    {
        return Registranttype::find($this->registranttype_id)->descr;
    }

    public function getRegistranttypeDescrBackgroundAttribute()
    {
        $descr = $this->getRegistranttypeDescrAttribute();

        switch($descr){
            case 'applied':
                $bg = 'bg-yellow-100';
                break;
            case 'prohibited':
                $bg = 'bg-red-100';
                break;
            case 'registered':
                $bg = 'bg-green-100';
                break;
            default:
                $bg = 'bg-white';
        }

        return $bg;
    }

    /**
     * Return timestamp of teacher signature
     */
    public function getSignatureconfirmationAttribute()
    {
        return Carbon::parse(Signature::where('registrant_id', $this->id)
            ->where('signaturetype_id', Signaturetype::TEACHER)
            ->first()->confirmed)
            ->format('M d, Y g:i a');
    }

    public function hasFileUploaded(Filecontenttype $filecontenttype): bool
    {
        return (bool)Fileupload::where('registrant_id', $this->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->first();
    }

    public function inpersonaudition()
    {
        return $this->hasOne(Inpersonaudition::class);
    }

    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class)
            ->withTimestamps()
            ->orderBy('abbr','asc');
    }

    /**
     * Return 'font-bold' if $user_id has entered any scores.
     * This is desiged to help the judges identify which registrants they have adjudicated
     * @param $user_id
     */
    public function judgeScoresEntered($user_id)
    {
        return (\App\Models\Score::where('registrant_id', $this->id)
                ->where('user_id', $user_id)
                ->first())
                ? 'font-bold'
                : '';
    }

    public function paid()
    {
        $amount = 0;

        foreach($this->payments AS $payment)
        {
            $amount += $payment->amount;
        }

        return $amount;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function registranttype()
    {
        return $this->belongsTo(Registranttype::class);
    }

    public function resetRegistrantType($descr)
    {
        $currenttype = Registranttype::find($this->registranttype_id);
        $newtype = Registranttype::where('descr', $descr)->first();

        switch($descr){
            case 'applied': //do not update record if applied, prohibited or registered
                if(
                    ($currenttype->id === Registranttype::ELIGIBLE) ||
                    ($currenttype->id === Registranttype::HIDDEN) ||
                    ($currenttype->id === Registranttype::NOAPP)
                ){
                    $this->registranttype_id = $newtype->id;
                    $this->save();
                    }
                break;

            default:
                $this->registranttype_id = $newtype->id;
                $this->save();
        }
    }

    public function scoringcomponentScore(\App\Models\Adjudicator $adjudicator, \App\Models\Scoringcomponent $scoringcomponent)
    {
        return \App\Models\Score::where('registrant_id', $this->id)
            ->where('user_id', $adjudicator->user_id)
            ->where('scoringcomponent_id', $scoringcomponent->id)
            ->value('score') ?? 0;
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class,'user_id', 'user_id');
    }

}
