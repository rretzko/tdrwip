<?php

namespace App\Http\Livewire\Students;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Studentroster extends Component
{
    public $countstudents;
    public $display_hide = true; //i.e. display
    public $schools;
    public $temp = [];

    protected $rules = [

    ];

    public function mount()
    {
        $this->countstudents = $this->countStudents();
        $this->schools = $this->schools();
        $this->temp = [0 => '23456'];
    }

    public function render()
    {
        return view('livewire.students.studentroster');
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function countStudents()
    {
        return DB::table('student_teacher')
            ->where('teacher_user_id', '=', auth()->id())
            ->count('student_user_id');
    }

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

}
