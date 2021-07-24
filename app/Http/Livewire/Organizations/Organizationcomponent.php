<?php

namespace App\Http\Livewire\Organizations;

use App\Models\Organization;
use Livewire\Component;

class Organizationcomponent extends Component
{
    //common contract properties for pages
    public $allowimports = true; //allow user to import ensemble members
    public $confirmingdelete = 0;
    public $perpage = 0; //pagination
    public $population = 0; //ALL members count
    public $search = '';
    public $selectall = false;
    public $selected = [];
    public $selectpage = 0;
    public $showaddmodal = false;
    public $showDeleteModal = false;
    public $showeditmodal = false;
    public $showfileuploadmodal = false;
    public $showfilters = false;
    public $sortdirection = 'asc';
    public $sortfield = '';

    //organization-specific properties
    private $organization = null;
    public $organizations = [];

    public function mount()
    {info(__CLASS__.': '.__METHOD__.': '.__LINE__);
        $organization = new Organization;
        $this->organizations = $organization->parents();
        info(__CLASS__.': '.__METHOD__.': '.__LINE__);
    }

    public function render()
    {
        return view('livewire.organizations.organizationcomponent');
    }
}
