<?php

namespace App\Http\Livewire\Ensembles;

use App\Models\Ensemble;
use App\Models\Ensemblemember;
use App\Models\Schoolyear;
use App\Models\Userconfig;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class Memberscomponent extends Component
{
    use WithPagination;

    //common contract properties for pages
    public $allowimports = true; //allow user to import ensemble members
    public $confirmingdelete = 0;
    public $perpage = 0; //pagination
    public $search = '';
    public $selectall = false;
    public $selectpage = 0;
    public $showaddmodal = false;
    public $showDeleteModal = false;
    public $showeditmodal = false;
    public $showfileuploadmodal = false;
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
  //      $this->ensembles = collect();
  //      $this->ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
        $this->instrumentations = collect();
        $this->members = collect();
  //      $this->schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());
  //      $this->schoolyear = Schoolyear::find($this->schoolyear_id);
        $this->schoolyears = Schoolyear::orderByDesc('id')->get();
  //      $this->teacher_user_id = auth()->id();

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

    public function delete($id)
    {
        if($this->confirmingdelete) {

            $this->editmember->delete();
            $this->reset([
                'confirmingdelete',
                'showeditmodal',
            ]);

        }else{

            $this->confirmingdelete = $id;
        }
    }

    public function edit($ensemblemember_id)
    {
        $this->editmember = Ensemblemember::find($ensemblemember_id);

        $this->ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
        $this->schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());
        $this->user_id = $ensemblemember_id;
        $this->teacher_user_id = auth()->id();

        $this->instrumentation_id = $this->editmember->instrumentation_id;

        $this->reset('confirmingdelete');
        $this->showeditmodal = true;
    }

    public function save()
    {
        $items = $this->validate();

        if((! $this->editmember) || (! $this->editmember->user_id)){

            return $this->saveNewMember();
        }

        $this->editmember->update([
            'instrumentation_id' => $this->instrumentation_id,
        ]);

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

    public function updatedPerpage()
    {
        Userconfig::setValue('pagination', auth()->id(), $this->perpage);
    }

    public function updatedSchoolyearId()
    {
        Userconfig::setValue('schoolyear_id', auth()->id(), $this->schoolyear_id);
        $this->schoolyear = Schoolyear::find($this->schoolyear_id);
    }

    public function updatedSelectpage($value)
    {
        $this->selected = ($value)
            //values must be cast as strings
            ? $this->members()->pluck('id')->map(fn($id) => (string)$id)
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

    private function members($page=0)
    {
        $members =  ($this->ensemble->members(Schoolyear::find($this->schoolyear_id)));
        $options = [];
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1 );
        $perpage = Userconfig::getValue('pagination', auth()->id());

        $items = $members instanceof Collection ? $members : Collection::make($members);
        return new LengthAwarePaginator($items->forPage($page,$perpage), $items->count(), $perpage, $page, $options);
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
        //restore deleted row or
        if (! $this->trashedEnsemblememberRestored()) {

            //add new member
            $this->editmember = Ensemblemember::create(
                [
                    'ensemble_id' => $this->ensemble_id,
                    'schoolyear_id' => $this->schoolyear_id,
                    'user_id' => $this->user_id,
                    'teacher_user_id' => $this->teacher_user_id,
                    'instrumentation_id' => $this->instrumentation_id,
                ]
            );
        }

         $this->showaddmodal = false;
         $this->showeditmodal = false;
    }

    private function searched($members)
    {
        $search = strtolower($this->search);

        return $members->filter(function($member) use ($search) {

                return str_contains(strtolower($member->person->last), $search);
        });
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

    private function trashedEnsemblememberRestored() : bool
    {
        //ensure that the ensemblemember has not been deleted
        $trashed = Ensemblemember::withTrashed()
            ->where('user_id', $this->user_id)
            ->where('ensemble_id', $this->ensemble_id)
            ->where('schoolyear_id', $this->schoolyear_id)
            ->first();

        return ($trashed)
            ? $trashed->restore()
            : false;
    }
}
