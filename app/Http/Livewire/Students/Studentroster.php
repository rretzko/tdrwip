<?php

namespace App\Http\Livewire\Students;

use App\Models\Pronoun;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Userconfig;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Studentroster extends Component
{
    public $countstudents=0;
    public $displayform = false;
    public $display_hide = true; //show the (def.) value
    public $filter;
    public $schoolid;
    public $schools;
    public $search = '';
    public $student = NULL;
    public $students = NULL;

    //student values
    public $first;
    public $last;
    public $middle;
    public $pronoun_id;
    public $pronouns;
    public $username;

    protected $rules = [
        'first' => ['string', 'required', 'min:2','max:60',],
        'middle' => ['string', 'nullable', 'max:60',],
        'pronoun_id' => ['required', 'integer'],
        'last' => ['string', 'required', 'min:2', 'max:60',],
        'username' => ['string', 'required'],
    ];

    public function mount()
    {
        $this->filter = Userconfig::getValue('filter_studentroster', auth()->id());
        $this->pronouns = Pronoun::orderBy('order_by')->get();
        $this->schoolid = $this->getSchoolId();
        $this->schools = $this->schools();
    }

    public function render()
    {
        $this->students = $this->search();
        $this->countstudents = $this->students->count();

        return view('livewire.students.studentroster');
    }

    public function studentForm($user_id)
    {
        //display the form
        $this->displayform = true;

        $this->student = Student::with('person')->find($user_id);
        $this->first = $this->student->person->first;
        $this->last = $this->student->person->last;
        $this->middle = $this->student->person->middle;
        $this->pronoun_id = $this->student->person->pronoun_id;
        $this->username = $this->student->person->user->username;
    }

    public function updatedFilter()
    {
        Userconfig::setValue('filter_studentroster', auth()->id(), $this->filter);
    }

    public function updatedSchoolid()
    {
        $this->getSchoolId();
    }


/** END OF PUBLIC FUNCTIONS **************************************************/

    private function getSchoolId()
    {
        //fetch the value from the current value from the database
        $stored = Userconfig::getValue('school_id', auth()->id());

        //initialize $this->>schoolid
        if(! $this->schoolid){ $this->schoolid = $stored;}

        //early exit
        if($stored === $this->schoolid){ return $stored;} //return the stored value

        //$this->schoolid has been changed; register and return the new value
        Userconfig::setValue('school_id', auth()->id(), $this->schoolid);

        //return the newly stored value (recursive function)
        self::getSchoolId();
    }

    private function schools()
    {
        $a = [];
        $user = User::find(auth()->id());

        foreach($user->schools AS $school){

            $a[$school->id] = $school->name;
        }

        asort($a);

        return $a;
    }

    private function search()
    {
        $teacher = Teacher::find(auth()->id());
        return $teacher->students($this->search);
    }

}
