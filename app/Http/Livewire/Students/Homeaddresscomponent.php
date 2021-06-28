<?php

namespace App\Http\Livewire\Students;

use Livewire\Component;

class Homeaddresscomponent extends Component
{
    public $student = null;

    public function render()
    {
        return view('livewire.students.homeaddresscomponent');
    }
}
