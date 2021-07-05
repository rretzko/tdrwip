<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Ensemblemember extends Model
{
    /**
     * @todo consider deconstructing model in many-to-many relationships:
     * @todo - ensemblemember: ensemble_id, user_id
     * @todo - ensemblemember_schoolyear: ensemblemember_id, schoolyear_id
     * @todo - ensemblemember_instrucmentation: ensemblemember_id, instrumentation_id
     * @todo - ensemblemember_teacher: ensemblemember_id, teacher_user_id
     */
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

    public function yearsInEnsemble()
    {
        return Ensemblemember::with('schoolyear')
            ->where('user_id', $this->user_id)
            ->where('ensemble_id', $this->ensemble_id)
            ->orderByDesc('schoolyear_id')
            ->get();
    }
}
