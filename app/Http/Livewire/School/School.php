<?php

namespace App\Http\Livewire\School;

use App\Models\Studio;
use Livewire\Component;

class School extends Component
{
    public $table_headers;
    public $table_schools;
    public $table_studios;

    public function mount()
    {
        $this->table_headers = ['Name', 'Location', 'Years', 'Action'];
        $this->table_schools = [];
        $this->table_studios = auth()->user()->person->teacher->studios;
    }

    public function render()
    {
        return view('livewire.school.update-school-information-form');
    }

/** END OF PUBLIC FUNCTIONS  *************************************************/

}
