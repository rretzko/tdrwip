<?php

namespace App\Http\Livewire\Ensembles;

use App\Models\Ensemble;
use App\Models\Ensemblemember;
use App\Models\Schoolyear;
use App\Models\Userconfig;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Memberscomponent extends Component
{
    //contract properties for pages
    public $search = '';
    public $selectall = false;
    public $selectpage = 0;
    public $showaddmodal = false;
    public $showDeleteModal = false;
    public $showeditmodal = false;
    public $showfilters = false;
    public $sortdirection = 'asc';
    public $sortfield = '';

    //properties specific to this concern
    public $editmember = null;
    public $ensemble = null;
    public $ensemble_id = 0;
    public $instrumentation_id = 1;
    public $schoolyear = null;
    public $schoolyear_id = 1960;
    public $schoolyears;
    public $teacher_user_id = 0;
    public $user_id = 0;

    public $ensembles;

    protected function rules()
    {
        return  [
            'ensemble_id' => ['required', 'integer',],
            'schoolyear_id' => ['required', 'integer',],
            'user_id' => ['required', 'integer', ],
            'teacher_user_id' => ['required', 'integer',],
            'instrumentation_id' => ['required', 'integer',],
        ];
    }

    public function mount()
    {
        $this->ensemble = Ensemble::find(Userconfig::getValue('ensemble_id', auth()->id()));
        $this->ensembles = collect();
        $this->ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
        $this->instrumentations = collect();
        $this->members = collect();
        $this->schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());
        $this->schoolyear = Schoolyear::find($this->schoolyear_id);
        $this->schoolyears = Schoolyear::orderByDesc('id')->get();
        $this->teacher_user_id = auth()->id();

    }

    public function render()
    {
        return view('livewire.ensembles.memberscomponent',
        [
            'instrumentations' => $this->instrumentationsArray(),
            'members' => $this->members(),
            'nonmembers' => $this->nonmembersArray(),
        ]);
    }

    public function save()
    {
        $input = $this->validate();

        if((! $this->editmember) || (! $this->editmember->user_id)){

            return $this->saveNewMember();
        }

        $this->emit('ensemblemember-saved');
    }

    public function selectAll()
    {
        $this->selectall = true;
        $this->selectpage = true;
        $this->updatedSelectpage(true);
    }

    public function sortField($value)
    {
        $this->sortdirection = ($this->sortfield === $value)
            ? (($this->sortdirection === 'asc') ? 'desc' : 'asc')
            : 'asc';

        $this->sortfield = $value;
    }

    public function updatedSelectpage($value)
    {
        $this->selected = ($value)
            //values must be cast as strings
            ? $this->ensembles()->pluck('id')->map(fn($id) => (string)$id)
            : [];
    }

    public function updatedShowaddmodal()
    {
        if($this->showaddmodal) {

            $this->editmember = new Ensemblemember;

            $this->ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
            $this->schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());
            $this->user_id = 0;
            $this->teacher_user_id = auth()->id();
            $this->instrumentation_id = array_key_first($this->instrumentationsArray());

            $this->showeditmodal = true;
        }
    }

/** END OF PUBLIC FUNCTIONS  *************************************************/

    private function instrumentationsArray() : array
    {
        $a = [];

        foreach ($this->ensemble->instrumentations() AS $instrumentation){
            $a[$instrumentation->id] = $instrumentation->formattedDescr();
        }

        asort($a);

        return $a;
    }

    private function members()
    {
        return $this->sorted($this->ensemble->members(Schoolyear::find($this->schoolyear_id)));
    }

    private function nonmembersArray(): array
    {
        $a = [];

        foreach($this->ensemble->nonmembers() AS $nonmember){
            $a[$nonmember->user_id] = $nonmember->person->fullNameAlpha;
        }

        asort($a);

        return $a;
    }

    private function saveNewMember()
    {
         $this->editmember = Ensemblemember::create(
            [
                'ensemble_id' => $this->ensemble_id,
                'schoolyear_id' => $this->schoolyear_id,
                'user_id' => $this->user_id,
                'teacher_user_id' => $this->teacher_user_id,
                'instrumentation_id' => $this->instrumentation_id,
            ]
        );

         $this->showaddmodal = false;
         $this->showeditmodal = false;
    }

    private function sorted(Collection $members)
    {
        //early exit: return $ensembles in name order
        if(! $this->sortfield){ return $members; }

        return $this->sortedNative($members);
    }

    private function sortedNative(Collection $members)
    {
        $nesteds = ['name', 'instrumentation'];

        //sortfield is column on the members table
        if(! in_array($this->sortfield, $nesteds)){

            return ($this->sortdirection === 'asc')
                ? $members->sortBy($this->sortfield)
                : $members->sortByDesc($this->sortfield);
        }

        $method = 'sortedNested'.ucwords($this->sortfield); //ex. sortedNestedName()
        return $this->$method($members);
    }

    /**
     * @todo figure out how to sort by members
     * @param $ensembles
     * @return mixed
     */
    private function sortedNestedName($members)
    {
        return ($this->sortdirection === 'asc')
            ? $members->sortBy('person.last')
            : $members->sortByDesc('person.last');
    }

    private function sortedNestedInstrumentation($members)
    {
        return ($this->sortdirection === 'asc')
            ? $members->sortBy('.instrumentation.descr')
            : $members->sortByDesc('instrumentation.descr');
    }
}
