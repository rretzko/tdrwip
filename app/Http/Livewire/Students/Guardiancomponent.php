<?php

namespace App\Http\Livewire\Students;

use Livewire\Component;

class Guardiancomponent extends Component
{
    public $student = null;

    public function render()
    {
        return view('livewire.students.guardiancomponent');
    }
}
