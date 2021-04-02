<?php

namespace App\Http\Livewire\Students;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Studentroster extends Component
{
    public $countstudents;
    public $display_hide = true; //i.e. display
    public $schools;
    public $students = NULL;

    protected $rules = [


    ];

    public function mount()
    {

        $this->schools = $this->schools();
        $this->students = $this->students();
        $this->countstudents = $this->students->count();

    }

    public function render()
    {
        return view('livewire.students.studentroster');
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function schools()
    {
        $a = [];
        $user = User::find(auth()->id());

        foreach($user->schools AS $school){

            $a[$school->id] = $school->name;
        }

        sort($a);

        return $a;
    }

    private function students()
    {
        $teacher = Teacher::find(auth()->id());
        return $teacher->students();
    }



}
