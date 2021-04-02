<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    public $school_id;
    public $student_user_id;
    public $teacher_user_id;

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

}
