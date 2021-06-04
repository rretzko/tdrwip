<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ensemblemember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['ensemble_id', 'instrumentation_id', 'schoolyear_id', 'teacher_user_id', 'user_id', ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id', 'user_id');
    }

    public function instrumentation()
    {
        return $this->belongsTo(Instrumentation::class);
    }

    public function schoolyear()
    {
        return $this->belongsTo(Schoolyear::class);
    }
}
