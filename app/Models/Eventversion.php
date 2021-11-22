<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Eventversion extends Model
{
    use HasFactory;

    protected $with = ['event','event.organization','eventversionconfigs'];

    public function dates(string $descr) : string
    {
        $datetype = Datetype::where('descr', $descr)->first();

        $dt = $this->eventversiondates
            ->where('datetype_id',$datetype->id)
            ->first()
            ->dt ?? null;

        //ex: Mon, Jul 19,2021 08:30
        return ($dt)
            ? Carbon::parse($dt)
                ->format('D, M d,Y H:i',$dt)
            : 'not found';
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventensembles()
    {
        return $this->belongsToMany(Eventensemble::class);
    }

    public function eventversionconfigs()
    {
        return $this->hasOne(Eventversionconfig::class);
    }

    public function eventversiondates()
    {
        return $this->hasMany(Eventversiondate::class);
    }

    public function eventversionteacherconfigs()
    {
        return $this->hasMany(Eventversionteacherconfig::class);
    }

    public function filecontenttypes()
    {
        return $this->belongsToMany(Filecontenttype::class)
            ->withPivot('title')
            ->orderByPivot('order_by')
            ->withTimestamps();
    }

    /**
     * @todo Either: Add this property to eventversionconfigs
     *       OR : Add this property to eApplications
     * @return int
     */
    public function getRequiredSignaturesCountAttribute()
    {
        if(($this->id === 66) || ($this->id === 67) || ($this->id === 69)){ //SJCDA 2021

            return 2; //signatureguardian and signaturestudent
        }

        return Signaturetype::all()->count();
    }

    /**
     * Returns a collection of instrumentations from $this first eventensemble
     */
    public function instrumentations()
    {
        return $this->eventensembles->first()->eventensembletype()->instrumentations;
    }

    public function isOpenForMembers()
    {//dd($this->eventversiondates()->where('datetype_id', 4)->first()->dt);
        //datetype_id of 4 = membership_close
        return Carbon::now() < $this->eventversiondates()->where('datetype_id', 4)->first()->dt ;
    }

    public function obligationMet($user_id)
    {
        return (bool)Obligation::where('user_id',$user_id)
            ->where('eventversion_id', $this->id)
            ->where('acknowledgment', 1)
            ->first();
    }

    public function pitchfiles()
    {
        return $this->hasMany(Pitchfile::class);
    }

    public function scoringcomponents()
    {
        return $this->hasMany(Scoringcomponent::class);
    }
}
