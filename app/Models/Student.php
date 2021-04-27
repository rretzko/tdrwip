<?php

namespace App\Models;

use App\Traits\SenioryearTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, SenioryearTrait;

    protected $primaryKey = 'user_id';

    public $school_id;
    public $student_user_id;
    public $teacher_user_id;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getEmailPersonalAttribute()
    {//dd(Nonsubscriberemail::where('user_id',$this->user_id)
     //   ->where('emailtype_id', Emailtype::where('descr', 'email_student_personal')->first()->id)
      //  ->first() ?? new Nonsubscriberemail);
        //dd(Emailtype::where('descr', 'email_student_personal')->first()->id);
        return Nonsubscriberemail::where('user_id',$this->user_id)
            ->where('emailtype_id', Emailtype::where('descr', 'email_student_personal')->first()->id)
            ->first()
            ?? new Nonsubscriberemail;
    }

    public function getEmailSchoolAttribute()
    {
        return Nonsubscriberemail::where('user_id',$this->user_id)
                ->where('emailtype_id', Emailtype::where('descr', 'email_student_school')->first()->id)
                ->first()
                ?? new Nonsubscriberemail;
    }

    /**
     * Return formatted birthdate
     * ex. January 4, 2021
     */
    public function getFbirthdayAttribute()
    {
        return Carbon::parse($this->birthday)->format('F d, Y');
    }

    public function getGradeAttribute()
    {
        $sr_year = $this->senioryear();

        //early exit
        if($this->classof < $sr_year){ return 'alum';}

        return (12 - ($this->classof - $sr_year));
    }

    public function getHeightFootInchAttribute()
    {
        return floor($this->height / 12)."' ".($this->height % 12).'" ('.$this->height.'")';
    }

    public function getPhoneHomeAttribute()
    {
        return Phone::where('user_id',$this->user_id)
                ->where('phonetype_id', Phonetype::where('descr', 'phone_student_home')->first()->id)
                ->first() ?? new Phone;
    }

    public function getPhoneMobileAttribute()
    {
        return Phone::where('user_id',$this->user_id)
                ->where('phonetype_id', Phonetype::where('descr', 'phone_student_mobile')->first()->id)
                ->first() ?? new Phone;
    }

    public function getStatusAttribute()
    {
        if($this->senioryear() > $this->classof){
            return 'alum';
        }

        return 'current';
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student', 'student_user_id', 'guardian_user_id')
            ->withPivot('guardiantype_id');
    }

    public function nonsubscriberemails()
    {
        return $this->hasMany(Nonsubscriberemail::class, 'user_id', 'user_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id', 'user_id');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'user_id', 'user_id');
    }

    public function shirtsize()
    {
        return $this->belongsTo(Shirtsize::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

/** END OF PUBLIC FUNCTIONS **************************************************/


}
