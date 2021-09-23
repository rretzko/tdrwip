<?php

namespace App\Http\Livewire\Students;

use App\Models\Gradetype;
use App\Models\Person;
use App\Models\Pronoun;
use App\Models\School;
use App\Models\Shirtsize;
use App\Models\Student;
use App\Models\Studenttype;
use App\Models\Teacher;
use App\Models\Tenure;
use App\Models\User;
use App\Models\Userconfig;
use App\Traits\SenioryearTrait;
use App\Traits\UsernameTrait;
use Carbon\Carbon;
use Livewire\Component;

class Profilecomponent extends Component
{
    use SenioryearTrait,UsernameTrait;

    public $birthday = '';
    public $classof = 0;
    public $classofs = [];
    public $first = '';
    public $height = 30;
    public $heights = [];
    public $heightininches = '3\' 0"';
    public $last = '';
    public $middle = '';
    public $pronoun_id = 1;
    public $pronouns = [];
    public $shirtsize_id = 1;
    public $shirtsizes = [];
    public $student = null;
    public $test = 'test';

    public function mount()
    {
        self::setStudentProperties();
        $this->classofs = self::setClassofs();
        $this->heights = self::setHeights();
        $this->pronouns = Pronoun::all()->sortBy('order_by');
        $this->shirtsizes = Shirtsize::all()->sortBy('order_by');
        $this->birthday = Carbon::now();
        $this->classof = $this->calcClassof();
    }

    public function render()
    {
        return view('livewire.students.profilecomponent');
    }

    public function save()
    {
        if(is_null($this->student)){
            $this->addNewStudent();

        }else {

            $this->student->birthday = $this->birthday;
            $this->student->classof = $this->classof;
            $this->student->height = $this->height;
            $this->student->shirtsize_id = $this->shirtsize_id;

            $this->student->save();

            $person = $this->student->person;

            $person->first = $this->first;
            $person->middle = $this->middle;
            $person->last = $this->last;

            $person->save();
        }

        $this->emit('profile-saved');
    }

    private function setStudentProperties()
    {
        //early exit
        if(! $this->student){ return '';}

        $this->birthday = $this->student->birthday;
        $this->classof = $this->student->classof;
        $this->first = $this->student->person->first;
        $this->height = $this->student->height;
        $this->last = $this->student->person->last;
        $this->middle = $this->student->person->middle;
        $this->pronoun_id = $this->student->person->pronoun_id;
        $this->shirtsize_id = $this->student->shirtsize_id;
    }

    private function setClassofs()
    {
        $a = [];

        //grades (ex. 9, 10, 11, 12) with classof as key
        foreach(Gradetype::first()->schoolUser() AS $gradetype){

            $classof = ($gradetype->id>12) ? $gradetype->id : ($this->senioryear() + (12 - $gradetype->id));
            $a[$classof] = $gradetype->descr;
        }

        //classofs starting with the $startyear of user/teacher for current school
        //WORKAROUND: DEFAULT TO PREVIOUS YEAR IF NO startyear FOUND
        /** @todo  Tenure::startyear should default to previous year upon School creation */
        $startyear = Tenure::where('user_id', auth()->id())
            ->where('school_id', Userconfig::getValue('school', auth()->id()))
            ->first()
            ->value('startyear') ?: (date('Y')-1);

        for($i = ($this->senioryear() - 1); $i >= $startyear; $i--){

            $a[$i] = $i;
        }

        //sort classofs in descending order
        krsort($a );

        return $a;
    }

    /**
     * heights range from 2' 6" to 7'
     */
    public function setHeights()
    {
        $a = [];

        for($i = 30; $i <= (7*12); $i++){

            $a[$i] = floor($i / 12)."' ".($i % 12).'"';
        }

        return $a;
    }

    private function addNewStudent()
    {
        //add user
        $user = User::create([
            'username' => $this->username($this->first,$this->last),
            'password' => bcrypt('Password1!'),
        ]);


        //add person
        Person::create([
            'user_id' => $user->id,
            'first' => $this->first,
            'middle' => $this->middle,
            'last' => $this->last,
            'pronoun_id' => $this->pronoun_id,
        ]);

        //add student
        $student = Student::create([
            'user_id' => $user->id,
            'classof' => $this->classof,
            'height' => $this->height,
            'birthday' => $this->birthday,
            'shirtsize_id' => $this->shirtsize_id,
        ]);

        $student=Student::find($user->id);

        //sync student to school
        $student->teachers()->sync([auth()->id() =>['studenttype_id' => Studenttype::TEACHER_ADDED]]);

        //sync student to teacher
        $user->schools()->sync(Userconfig::getValue('school', auth()->id()));
    }

    private function calcClassof()
    {
        if($this->student){

            return $this->student->classof;
        }
        return date('Y');
    }
}
