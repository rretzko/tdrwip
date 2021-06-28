<?php

namespace App\Http\Livewire\Students;

use App\Models\Gradetype;
use App\Models\Pronoun;
use App\Models\School;
use App\Models\Shirtsize;
use App\Models\Teacher;
use App\Models\Tenure;
use App\Models\Userconfig;
use App\Traits\SenioryearTrait;
use Livewire\Component;

class Profilecomponent extends Component
{
    use SenioryearTrait;

    public $birthday = '';
    public $classof = 0;
    public $classofs = [];
    public $first = '';
    public $height = 30;
    public $heights = [];
    public $heightininches = '3\' 0"';
    public $last = '';
    public $middle = '';
    public $pronoun_id = '';
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
    }

    public function render()
    {
        return view('livewire.students.profilecomponent');
    }

    public function save()
    {
        $this->student->birthday = $this->birthday;
        $this->student->classof = $this->classof;
        $this->student->height = $this->height;
        $this->student->shirtsize_id =$this->shirtsize_id;

        $this->student->save();

        $person = $this->student->person;

        $person->first = $this->first;
        $person->middle = $this->middle;
        $person->last = $this->last;

        $person->save();

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
        $startyear = Tenure::where('user_id', auth()->id())
            ->where('school_id', Userconfig::getValue('school_id', auth()->id()))
            ->first()
            ->value('startyear');

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
}
