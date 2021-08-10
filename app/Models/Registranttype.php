<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registranttype extends Model
{

    protected $fillable = ['id','descr'];

    const ELIGIBLE = 14;

    public function registrants()
    {
        return $this->hasMany(Registrant::class);
    }
}
