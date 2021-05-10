<?php

namespace App\Models;

use App\Traits\SenioryearTrait;
use App\Traits\UpdateSearchablesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, SenioryearTrait, UpdateSearchablesTrait;

    protected $fillable = ['user_id'];

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
        return Carbon::parse($this->birthday)->format('M d, Y');
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

    public function searchName($str="bla")
    {
        $items = Person::all()->filter(function($record) use($str) {
            if(($record->first) == $searchValue) {
                return $record;
            }
        });
    }

    public function setSearchables()
    {
        $user = $this->person->user;

        $this->updateSearchables($user, 'name', $this->person->first.$this->person->middle.$this->person->last);
        $this->updateSearchables($user, 'email_student_personal', $this->emailPersonal->email);
        $this->updateSearchables($user, 'email_student_school', $this->emailSchool->email);
        $this->updateSearchables($user, 'phone_student_home', $this->phoneHome);
        $this->updateSearchables($user, 'phone_student_mobile', $this->phoneMobile);
    }

    public function shirtsize()
    {
        return $this->belongsTo(Shirtsize::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class,'student_teacher','student_user_id', 'teacher_user_id')
            ->withPivot('studenttype_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

/** END OF PUBLIC FUNCTIONS **************************************************/


}
