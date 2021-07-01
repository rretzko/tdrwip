<?php

namespace App\Http\Livewire\Ensembles;

use App\Exports\EnsemblesExport;
use App\Helpers\CollectionHelper;
use App\Models\Ensemble;
use App\Models\Ensemblemember;
use App\Models\Ensembletype;
use App\Models\Userconfig;
use App\Traits\SenioryearTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Ensemblecomponent extends Component
{
    use WithPagination, SenioryearTrait;

    public $abbr = '';
    public $descr = '';
    public $editensemble = null;
    public $ensembletype_id = 1;
    public $ensembletypes = [];
    public $filterstring = '';
    public $name = '';
    public $perpage = 0;
    public $search = '';
    public $selected = [];
    public $selectpage = false;
    public $showfilters = false;
    public $showAddModal = false;
    public $showeditmodal = false;
    public $showDeleteModal = false;
    public $sortdirection = 'asc';
    public $sortfield = '';
    public $startyear = 1960;
    public $years = [];

    public function mount()
    {
        $this->ensembletypes = Ensembletype::all();
        $this->perpage = Userconfig::getValue('pagination', auth()->id());
        $this->students = collect();
        $this->years = array_fill($this->senioryear()+1, ($this->senioryear()+1-1960), -1);
    }

    public function render()
    {
        return view('livewire.ensembles.ensemblecomponent',
        [
            'ensembles' => $this->ensembles(),

        ]);
    }

    public function deleteSelected()
    {
        Ensemble::destroy($this->selected);
        $this->showDeleteModal = false;
        $this->selected = [];
    }

    public function edit($ensemble_id)
    {
        $this->editensemble = Ensemble::find($ensemble_id);
        $this->showeditmodal = true;

        $this->name = $this->editensemble->name;
        $this->abbr = $this->editensemble->abbr;
        $this->ensembletype_id = $this->editensemble->ensembletype_id;
        $this->startyear = $this->editensemble->startyear;
    }

    public function exportSelected()
    {
        $ensembles  = new EnsemblesExport(Ensemble::whereKey($this->selected)->get());

        //resetSelects
        $this->selected = [];
        $this->selectall = false;
        $this->selectpage = false;

        return Excel::download($ensembles, 'ensembles.csv');
    }


    public function updatedPerpage()
    {
        Userconfig::setValue('pagination', auth()->id(), $this->perpage);
    }

    public function sortField($value)
    {
        $this->sortdirection = ($this->sortfield === $value)
            ? (($this->sortdirection === 'asc') ? 'desc' : 'asc')
            : 'asc';

        $this->sortfield = $value;
    }

/** END OF PUBLIC FUNCTIONS  *************************************************/

    private function ensembles()
    {
        return $this->sorted(Ensemble::where('name', 'LIKE', '%'.$this->search.'%')
                ->where('school_id', Userconfig::getValue('school_id', auth()->id()))
                ->with('ensembletype', 'ensembletype.instrumentations')
                ->orderBy('name')
                ->get());
    }

    private function sorted(Collection $ensembles)
    {
        //early exit: return $ensembles in name order
        if(! $this->sortfield){ return $ensembles; }

        return $this->sortedNative($ensembles);
    }

    private function sortedNative(Collection $ensembles)
    {
        $nesteds = ['members', 'type'];

        //sortfield is field on the ensembles table
        if(! in_array($this->sortfield, $nesteds)){

            return ($this->sortdirection === 'asc')
                ? $ensembles->sortBy($this->sortfield)
                : $ensembles->sortByDesc($this->sortfield);
        }

        $method = 'sortedNested'.ucwords($this->sortfield); //ex. sortedNestedInstrumentation()
        return $this->$method($ensembles);
    }

    /**
     * @todo figure out how to sort by members
     * @param $ensembles
     * @return mixed
     */
    private function sortedNestedMembers($ensembles)
    {
        return ($this->sortdirection === 'asc')
            ? $ensembles->sortBy('name')
            : $ensembles->sortByDesc('name');
    }

    private function sortedNestedType($ensembles)
    {
        return ($this->sortdirection === 'asc')
            ? $ensembles->sortBy('startyear')
            : $ensembles->sortByDesc('ensembletype.descr');
    }


}
