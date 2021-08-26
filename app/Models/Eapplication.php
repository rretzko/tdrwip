<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eapplication extends Model
{
    use HasFactory;

    protected $fillable = ['eventversion_id', 'registrant_id','signatureguardian','signaturestudent'];
    protected $primaryKey = 'registrant_id';

    public function registrant()
    {
        return $this->belongsTo(Registrant::class);
    }
}
