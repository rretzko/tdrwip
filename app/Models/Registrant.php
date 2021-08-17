<?php

namespace App\Models;

use App\Models\Utility\Fileviewport;
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

    public function getHasApplicationAttribute(): bool
    {
        return (bool)Application::where('registrant_id', $this->id)->first();
    }

    public function getHasFileuploadsAttribute(): bool
    {
        $eventversion = Eventversion::find(Userconfig::getValue('eventversion',auth()->id()));
        $fileuploadtypescount = $eventversion->filecontenttypes->count();
        $approvedscount = $this->fileuploads->whereNotNull('approved')->count();

        return $fileuploadtypescount === $approvedscount;
    }

    public function getHasInstrumentationAttribute(): bool
    {
        return (bool)$this->instrumentations;
    }

    public function getHasSignaturesAttribute() : bool
    {
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

    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class)
            ->withTimestamps()
            ->orderBy('abbr','asc');
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

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class,'user_id', 'user_id');
    }

}