<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    protected $fillable = ['confirmed', 'confirmed_by', 'registrant_id', 'signaturetype_id',];

    public function registrant()
    {
        return $this->belongsTo(Registrant::class);
    }


}
