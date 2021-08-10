<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    use HasFactory;

    protected $fillable = ['eventversion_id', 'id', 'school_id', 'user_id'];

    protected $with = ['student','instrumentations'];

    public function getInstrumentationCSVAttribute()
    {
        $descrs = [];

        foreach($this->instrumentations AS $instrumentation){
            $descrs[] = $instrumentation->abbr;
        }

        return ($descrs) ? implode(',',$descrs) : 'None found';
    }

    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class)
            ->withTimestamps()
            ->orderBy('abbr','asc');
    }

    public function registranttype()
    {
        return $this->hasOne(Registranttype::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class,'user_id', 'user_id');
    }
}
