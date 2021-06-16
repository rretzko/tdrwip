<?php

namespace App\Http\Livewire\Ensembles;

use App\Models\Asset;
use App\Models\Ensemble;
use App\Models\Userconfig;
use Livewire\Component;

class AssetsTable extends Component
{
    /**
     * @todo add Edit and Delete buttons to views/livewire/ensembles/assets-table.blade.php
     * - Can edit/delete when asset was added by auth()->id() AND no-one other than auth()->id() has used it
     * - On delete: Cascading delete if ensemblemembers have been assigned the asset
     */
    public $assets = null;
    public $assettypes = [];
    public $ensemble = null;
    public $ensembleassets; //passed from @livewire('AssetsTable', ['ensembleassets' => $ensembleassets])
    public $mssg = '';
    public $tbl = '';
    public $initialassets; //array of assets at the beginning of process
    public $assetsupdated = false;

    public function mount()
    {
        $this->assets = Asset::orderBy('descr')->get();
        $this->ensemble = Ensemble::find(Userconfig::getValue('ensemble_id', auth()->id()));
        $this->ensembleassets = $this->ensemble->assets;
        $this->initialassets = $this->ensembleassets;
        $this->setAssettypes();
        $this->mssg = $this->setMssg();
    }

    public function render()
    {
        return view('livewire.ensembles.assets-table');
    }

    public function rules()
    {
        return [
          'assets.*' => ['nullable','numeric'],
        ];
    }

    public function updatedAssettypes()
    {
        $this->ensemble->assets()->sync($this->assettypes);
        $this->ensemble->refresh();
        $this->ensembleassets = $this->ensemble->assets;
        $this->mssg = $this->setMssg();
        $this->assetsupdated = true;
    }

    private function setAssettypes()
    {
        foreach($this->ensembleassets AS $ensembleasset){

            //NOTE: MUST be strval; integers fail
            $this->assettypes[] = strval($ensembleasset->id);
        }
    }

    private function setMssg()
    {
        if($this->ensemble->assets->count()) {
            $str = 'The asset'.(($this->ensembleassets->count() > 1) ? 's' : '').' for <b>' . $this->ensemble->name . '</b>';
            $str .= (($this->ensembleassets->count() > 1) ? ' are: ' : ' is: ');
            $str .= '<ul class="ml-10 list-disc">';
            foreach($this->ensembleassets AS $ensembleasset){
                $str .= '<li>'.$ensembleasset->descr.'</li>';
            }
            $str .= '</ul>';
        }else{
            $str = 'No assets found for <b>'.$this->ensemble->name.'</b>';
        }

        return $str;

    }
}
