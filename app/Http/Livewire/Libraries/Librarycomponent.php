<?php

namespace App\Http\Livewire\Libraries;

use App\Models\Composition;
use App\Models\Geostate;
use App\Models\Publisher;
use Livewire\Component;
use Livewire\WithPagination;

class Librarycomponent extends Component
{
    use WithPagination;

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

    //library-specific properties
    public $editcomposition = null;
    public $ensembles = [];
    public $geostates = [];
    //publisher
    public $publisherslist = [];
    public $publisheraddress0 = '';
    public $publisheraddress1 = '';
    public $publishercity = '';
    public $publishergeostateid = 37; //NJ
    public $publisherpostalcode = '';
    public $publisherid = 0;
    public $publishername = '';
    public $publishers = [];
    public $showpublisherform = false;

    public function mount()
    {
        $this->geostates = $this->geostates();
        $this->publishers = Publisher::all();
        $this->refreshPublishersList();
    }
    public function render()
    {
        return view('livewire.libraries.librarycomponent');
    }

    public function savepublisher()
    {
        $publisher = Publisher::create([
            'name' => $this->publishername,
            'address0' => $this->publisheraddress0,
            'address1' => $this->publisheraddress1,
            'city' => $this->publishercity,
            'geostate_id' => $this->publishergeostateid,
            'postalcode' => $this->publisherpostalcode,
        ]);

        $this->publisherid = $publisher->id;

        $this->publishers = Publisher::all();
        $this->refreshPublishersList();

        $this->reset('publisheraddress0', 'publisheraddress1', 'publishercity', 'publishergeostateid',
            'publisherpostalcode');

        $this->showpublisherform = false;

    }

    public function updatedPublishername()
    {
        if(! Publisher::where('name', $this->publishername)->first()){

            $this->showpublisherform = true;
        }
    }

    public function updatedShowaddmodal()
    {
        $this->editcomposition = new Composition;
        $this->showeditmodal = true;
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function geostates()
    {
        $a = [];

        foreach(Geostate::all() AS $geostate){
            $a[$geostate->id] = $geostate->abbr;
        }

        return $a;
    }

    private function refreshPublishersList()
    {
        foreach(Publisher::all() AS $publisher){

            $this->publisherslist[$publisher->id] = $publisher->name;
        }
    }
}
