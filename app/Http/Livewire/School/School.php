<?php

namespace App\Http\Livewire\School;

use App\Models\Geostate;
use App\Models\Studio;
use Livewire\Component;

class School extends Component
{
    public $entity = NULL; //school or studio
    public $entity_type = 'School';
    public $message = 'Successful update!';
    public $options = [];
    public $showEditModal = false;
    public $table_headers;
    public $table_schools;
    public $table_studios;

    public $name = '';
    public $address01 = '';
    public $address02 = '';
    public $city = '';
    public $geostate_id = 0;
    public $postalcode = '';
    public $entity_id = 0;
    public $years = [];
    public $startyear = 1960;
    public $endyear = 0;
    public $startyears = [];
    public $endyears = [];

    protected $rules = [
        'name' => ['required', 'min:5', 'max:60'],
        'address01' => ['string', 'nullable', 'max:120'],
        'address02' => ['string', 'nullable', 'max:120'],
        'city' => ['string', 'nullable', 'max:60'],
        'geostate_id' => ['required', 'integer'],
        'postalcode' => ['string', 'nullable', 'max:15'],
        'startyear' => ['required', 'integer'],
        'endyear' => ['integer', 'nullable'], //before:startyear if not null
    ];

    public function mount()
    {
        $this->table_headers = ['Name', 'Location', 'Years', 'Actions'];
        $this->table_schools = [];
        $this->table_studios = auth()->user()->person->teacher->studios;
        $this->options = $this->geostates();
        $this->startyears = $this->years();
        $this->endyears = $this->years(true);
    }

    public function edit($school, $id)
    {
        $this->entity = ($school) ? School::find($id) : Studio::find($id);

        $this->entity_type = ($school) ? 'School' : 'Studio';
        $this->entity_id = $this->entity->id;
        $this->name = $this->entity->name;
        $this->address01 = $this->entity->address01;
        $this->address02 = $this->entity->address02;
        $this->city = $this->city;
        $this->geostate_id = $this->entity->geostate_id;
        $this->postalcode = $this->entity->postalcode;

        $this->showEditModal = true;
    }

   public function render()
    {
        return view('livewire.school.update-school-information-form');
    }

    public function save()
    {
        $this->validate();

        $this->entity->name = $this->name;
        $this->entity->address01 = $this->address01;
        $this->entity->address02 = $this->address02;
        $this->entity->city = $this->city;
        $this->entity->geostate_id = $this->geostate_id;
        $this->entity->postalcode = $this->postalcode;
        $this->entity->save();

        $this->showEditModal = false;
        $this->table_studios = auth()->user()->person->teacher->studios;
    }


/** END OF PUBLIC FUNCTIONS  *************************************************/

    private function geostates()
    {
        $a = [];

        foreach(Geostate::all() AS $geostate){
            $a[$geostate->id] = $geostate->abbr;
        }

        return $a;
    }

    private function years($blankoption=false)
    {
        $a = [];

        if($blankoption){$a[0] = '';}

        for($i=date('Y'); $i>1959; $i--){
            $a[$i] = $i;
        }

        return $a;
    }

}
