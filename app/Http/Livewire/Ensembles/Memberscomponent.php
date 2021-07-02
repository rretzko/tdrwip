<?php

namespace App\Http\Livewire\Ensembles;

use Livewire\Component;

class Memberscomponent extends Component
{
    public $search = '';
    public $selectall = false;
    public $selectpage = 0;
    public $showaddmodal = false;
    public $showDeleteModal = false;
    public $showeditmodal = false;
    public $showfilters = false;
    public $sortfield = '';

    public $ensembles;

    public function mount()
    {
        $this->ensembles = collect();
    }

    public function render()
    {
        return view('livewire.ensembles.memberscomponent');
    }
}
