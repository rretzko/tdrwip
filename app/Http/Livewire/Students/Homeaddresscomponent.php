<?php

namespace App\Http\Livewire\Students;

use App\Models\Geostate;
use Livewire\Component;

class Homeaddresscomponent extends Component
{
    public $address01;
    public $address02;
    public $city;
    public $geostate_id;
    public $geostates;
    public $postalcode;
    public $student = null;

    protected $rules = [
        'address01' => ['nullable', 'string',],
        'address02' => ['nullable', 'string',],
        'city' => ['nullable', 'string',],
        'geostate_id' => ['required', 'integer',],
        'postalcode' => ['nullable', 'string', 'min:5','max:25'],
    ];

    protected $validationAttributes = [
        'address01' => 'first address',
        'address02' => 'second address',
        'geostate_id' => 'state',
        'postalcode' => 'zip code',
    ];

    public function mount()
    {
        $address = $this->student->person->user->address;
        $this->address01 = $address->address01;
        $this->address02 = $address->address02;
        $this->city = $address->city;
        $this->geostate_id = $address->geostate_id;
        $this->postalcode = $address->postalcode;
        $this->geostates = $this->geostates();
    }

    public function render()
    {
        return view('livewire.students.homeaddresscomponent');
    }

    public function save()
    {
        $address = $this->student->person->user->address;
        $address->address01 = $this->address01;
        $address->address02 = $this->address02;
        $address->city = $this->city;
        $address->geostate_id = $this->geostate_id;
        $address->postalcode = $this->postalcode;

        $address->save();

        $this->emit('homeaddress-saved');
    }

    private function geostates()
    {
        $a = [];

        foreach(Geostate::all()->sortBy('name') AS $geostate){
            $a[$geostate->id] = $geostate->name;
        }

        return $a;
    }
}