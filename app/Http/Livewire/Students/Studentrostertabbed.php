<?php

namespace App\Http\Livewire\Students;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Userconfig;
use Livewire\Component;

class Studentrostertabbed extends Component
{
    public $activetab;
    public $displayform = false;
    public $displayhide;
    public $countstudents;
    public $filter;
    public $schools;
    public $search;
    public $student = NULL;
    public $students;
    public $teacher;

    public function mount()
    {
        $this->activetab = Userconfig::getValue('studentform', auth()->id());
        $this->displayhide = Userconfig::getValue('pagedef_students', auth()->id());
        $this->filter = Userconfig::getValue('filter_studentroster', auth()->id());
        $this->schools = $this->schools();
    }

    public function render()
    {
        $this->students = $this->search();
        $this->countstudents = $this->students->count();
        $this->teacher = Teacher::with(['person', 'person.user','person.honorific', ])->find(auth()->id());

        return view('livewire.students.studentrostertabbed',[]);
    }

    public function studentForm($user_id)
    {
        $this->student = Student::find($user_id);
        //final action
        $this->displayform = true;
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

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

    public function updatedDisplayhide()
    {
        Userconfig::setValue('pagedef_students', auth()->id(), $this->displayhide);
    }

    public function updatedFilter()
    {
        Userconfig::setValue('filter_studentroster', auth()->id(), $this->filter);
    }

}
