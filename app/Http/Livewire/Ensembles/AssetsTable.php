<?php

namespace App\Http\Livewire\Ensembles;

use App\Models\Asset;
use App\Models\Ensemble;
use App\Models\Userconfig;
use Livewire\Component;

class AssetsTable extends Component
{
    public $assets = null;
    public $assettypes=[];
    public $ensemble = null;
    public $ensembleassets = null;
    public $mssg = '';

    public function mount()
    {
        $this->assets = Asset::orderBy('descr')->get();
        $this->ensemble = Ensemble::find(Userconfig::getValue('ensemble_id', auth()->id()));
        $this->ensembleassets = $this->ensemble->assets;
    }

    public function render()
    {
        return view('livewire.ensembles.assets-table');
    }

    public function updatedAssettypes()
    {
        $mssg = $this->ensemble->name.' assets are: ';
        $this->ensemble->assets()->sync($this->assettypes);
        $this->ensemble->refresh();
        foreach($this->ensemble->assets AS $asset){

            $mssg .= $asset->descr.', ';
        }

        $this->mssg = substr($mssg, 0, (strlen($mssg)-1)).'.';
    }
}
