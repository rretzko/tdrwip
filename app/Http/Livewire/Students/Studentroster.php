<?php

namespace App\Http\Livewire\Students;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Userconfig;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Studentroster extends Component
{
    public $countstudents=0;
    public $display_hide = true; //show the (def.) value
    public $schoolid;
    public $schools;
    public $search = '';
    public $students = NULL;

    protected $rules = [

    ];

    public function mount()
    {
        $this->schoolid = $this->getSchoolId();
        $this->schools = $this->schools();
    }

    public function render()
    {
        $this->students = $this->search();
        $this->countstudents = $this->students->count();

        return view('livewire.students.studentroster');
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
