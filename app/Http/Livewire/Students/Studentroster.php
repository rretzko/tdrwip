<?php

namespace App\Http\Livewire\Students;

use Livewire\Component;

class Studentroster extends Component
{
    public $display_hide = true; //i.e. display

    protected $rules = [
    ];

    public function render()
    {
        return view('livewire.students.studentroster');
    }

}
