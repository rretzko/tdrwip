<?php

namespace App\Http\Livewire\Students;

use App\Models\Student;
use Livewire\Component;

class Communicationcomponent extends Component
{
    public $student = null;

    public function render()
    {
        return view('livewire.students.communicationcomponent');
    }
}
