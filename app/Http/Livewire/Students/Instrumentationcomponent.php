<?php

namespace App\Http\Livewire\Students;

use App\Models\Instrumentation;
use App\Models\Instrumentationbranch;
use Livewire\Component;

class Instrumentationcomponent extends Component
{
    public $addinstrumentation = true;
    public $branch_id = 1;
    public $branches = [];
    public $student = null;
    public $instrumentations = [];
    public $studentinstrumentations = [];

    public function mount()
    {
        $this->branches = Instrumentationbranch::all();
        $this->instrumentations = Instrumentation::all();
        $this->studentinstrumentations = $this->student->person->user->instrumentations;
    }

    public function render()
    {
        return view('livewire.students.instrumentationcomponent');
    }

    public function updatedBranchId()
    {
        dd($this->branch_id);
    }
}
