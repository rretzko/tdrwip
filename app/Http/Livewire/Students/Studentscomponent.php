<?php

namespace App\Http\Livewire\Students;

use App\Exports\StudentsExport;
use App\Helpers\CollectionHelper;
use App\Models\Instrumentation;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Userconfig;
use App\Traits\SenioryearTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class Studentscomponent extends Component
{
    use SenioryearTrait,WithPagination;

    public $instrumentations = [];
    public $perpage = 0;
    public $population = 'all';
    public $search = '';
    public $selectall = false;
    public $selected = [];
    public $selectpage = false;
    public $showDeleteModal = false;
    public $showfilters = false;
    public $sortdirection = 'asc';
    public $sortfield = '';

    //non-paginated population of students
    private $populationstudents = null;

    protected $rules = [
        'grade' => ['requried'],
        'name' => ['required'],
    ];

    public function exportSelected()
    {
        $user_ids = $this->selected;
        $students = Teacher::find(auth()->id())->myStudents($this->search);
        $selecteds = ($this->selectall)
            ? $students
            : $students->filter(function($student) use ($user_ids){
                (is_array($user_ids))
                    ? in_array($student->user_id, $user_ids)
                    : $user_ids->contains($student->user_id); });

        $filtered = $this->filterPopulation($selecteds);
        $sorted = $this->sorted($filtered);
        $this->selected = $sorted->pluck('user_id')->map(fn($user_id) => (string)$user_id);
        $students = new StudentsExport(Student::whereKey($this->selected)->get());

        //resetSelects
        $this->selected = [];
        $this->selectall = false;
        $this->selectpage = false;

        return Excel::download($students, 'students.csv');
    }

    public function mount()
    {
        $this->perpage = Userconfig::getValue('pagination', auth()->id());
    }

    public function population($value)
    {
        $this->population = $value;
        $this->selectall = false;
        $this->selectpage = false;
        $this->selected = [];
    }

    public function render()
    {
        return view('livewire.students.studentscomponent',
            [
                'students' => $this->students(),
                'sortedclassofs' => $this->classofsArray(),
                'sortedinstrumentations' => $this->instrumentationsArray(),
            ]);
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

    public function updatedSelectAll($value)
    {
        $this->selectall = true;
    }

    public function updatedSelectpage($value)
    {
        $students = $this->students();

        $this->selected = ($value)
            //values must be cast as strings
            ? $this->students()->pluck('user_id')->map(fn($user_id) => (string)$user_id)
            : [];
    }

    /** END OF PUBLIC FUNCTIONS  *************************************************/

    private function classofsArray()
    {
        $a = [];

        foreach($this->populationstudents AS $student){

            $a[$student->classof] = $student->classof;

        }

        sort($a);

        return $a;
    }

    public function deleteSelected()
    {
        auth()->user()->person->teacher->removeStudents($this->selected);
        $this->showDeleteModal = false;
        $this->selected = [];
    }

    private function filterPopulation(Collection $students)
    {
        //early exit
        if($this->population === 'all'){ return $students;}

        $senioryear = $this->senioryear();

        return ($this->population === 'current')
            ? $students->filter(function($student) use($senioryear) {
                return $student->classof >= $senioryear;
            })
            : $students->filter(function($student) use($senioryear) {
                return $student->classof < $senioryear;
            });
    }

    private function instrumentationsArray()
    {
        $a = [];

        foreach($this->populationstudents AS $student){
            foreach($student->person->user->instrumentations AS $instrumentation){

                $a[$instrumentation->id] = $instrumentation->formattedDescr();
            }
        }

        sort($a);

        return $a;
    }

    private function students()
    {
        //pull this teacher's students
        $students = Teacher::find(auth()->id())->myStudents($this->search);

        //filter and sort student population
        $filtered  = $this->filterPopulation($students);
        //pre-pagination collection of students filtered by population
        $this->populationstudents = $this->sorted($filtered);

        //paginate identified students
        return CollectionHelper::paginate($this->populationstudents, Userconfig::getValue('pagination', auth()->id()));
    }

    private function sorted(Collection $students)
    {
        //early exit: return $students in fullNameAlpha order
        if(! $this->sortfield){ return $students; }

        return $this->sortedNative($students);
    }

    private function sortedNative(Collection $students)
    {
        $nesteds = ['instrumentation', 'name'];

        //sortfield is field on the students table
        if(! in_array($this->sortfield, $nesteds)){

            return ($this->sortdirection === 'asc')
                ? $students->sortBy($this->sortfield)
                : $students->sortByDesc($this->sortfield);
        }

        $method = 'sortedNested'.ucwords($this->sortfield); //ex. sortedNestedInstrumentation()
        return $this->$method($students);
    }

    private function sortedNestedInstrumentation(Collection $students)
    {
        return ($this->sortdirection === 'asc')
            ? $students->sortBy(function($student) {
                return $student->person->user->instrumentations->first()->formattedDescr();
            })
            : $students->sortByDesc(function($student) {
                return $student->person->user->instrumentations->first()->formattedDescr();
            });
    }

    private function sortedNestedName(Collection $students)
    {
        return ($this->sortdirection === 'asc')
            ? $students->sortBy(function($student) {
                    return $student->person->last.$student->person->first;
                })
            : $students->sortByDesc(function($student) {
                return $student->person->last.$student->person->first;
            });
    }
}
