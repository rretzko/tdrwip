<?php

namespace App\Http\Livewire\Organizations;

use App\Models\Organization;
use Livewire\Component;

class Organizationcomponent extends Component
{
    //common contract properties for pages
    public $allowimports = true; //allow user to import ensemble members
    public $confirmingdelete = 0;
    public $membershipmanagers = [];
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
    {
        $organization = new Organization;
        $this->organizations = $organization->parents();
        $this->membershipmanagers = $this->membershipManagers();
    }

    public function render()
    {
        return view('livewire.organizations.organizationcomponent');
    }

    public function membershipmanagers()
    {
        $a = [];

        foreach($this->organizations AS $organization){

            //includes the parent branch
            foreach($organization->decendentsTree() AS $branch) {

                if ($branch->hasMembershipmanagers) {

                    $str = 'Membership manager name goes here';

                    //foreach($organization->membershipmanagers() AS $membershipmanager){

                    //    $str =

                    //}

                    $a[$branch->id] = $str;


                } else {

                    $a[$branch->id] = 'No membership manager found.';
                }
            }
        }

        //$a[3] = 'Barbara Retzko (barbararetzko@hotmail.com)';

        return $a;
    }
}
