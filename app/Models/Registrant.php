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

    public function getInstrumentationsCSVAttribute()
    {
        $descrs = [];

        foreach($this->instrumentations AS $instrumentation){
            $descrs[] = $instrumentation->abbr;
        }

        return ($descrs) ? implode(',',$descrs) : 'None found';
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

    public function student()
    {
        return $this->belongsTo(Student::class,'user_id', 'user_id');
    }

}
