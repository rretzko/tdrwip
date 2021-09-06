<?php

namespace App\Http\Livewire\Siteadministration;

use App\Models\Person;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Siteadministrator extends Component
{
    public $search='';
    public $searchschool='';
    //public $selectedschool=NULL;
    public $selectedschoolname='';
    public $students=NULL;
    public $teachers=NULL;

    private $selectedteachers=[];

    public function mount()
    {
        //$this->selectedschool = NULL;
        //$this->selectedschoolname = '';
        //$this->students=NULL;
        //$this->teachers=NULL;
    }

    public function render()
    {
        return view('livewire.siteadministration.siteadministrator',
        [
            'persons' => $this->persons(),
            'schools' => $this->schools(),
        ]);
    }

    public function transferStudents()
    {
        $studentuserids = [3610,3639,3583,3568,1267,3628,3561,2817];

        foreach($studentuserids AS $id){
            DB::table('student_teacher')
                ->where('student_user_id', '=', $id)
                ->where('teacher_user_id', '=', 54)
                ->update(['teacher_user_id' => 8495]);
        }

    }

    public function updateSchool($value)
    {
        $this->selectedschool = School::find($value);
        $this->selectedschoolname = ($this->selectedschool ? $this->selectedschool->name : '');
        $this->students = $this->selectedschool->currentStudents;
        $this->teachers = $this->selectedschool->teachersForTransfer();
        //$this->reset('searchschool');
    }

    public function updatedSearch($value)
    {
        //$this->reset(['selectedschool','selectedschoolname', 'teachers']);

        //$this->render();
    }

    public function updatedSearchschool()
    {
        //$this->reset('search','selectedschool','selectedschoolname','selectedteachers','students','teachers');

        //$this->render();
    }

    public function updateSelectedTeachers($value)
    {
        $this->selectedteachers[] = $value;
    }

    private function persons()
    {
        //early exit
        if(! strlen($this->search)){ return collect(); }

        $likevalue = '%'.$this->search.'%';

        return Person::where('last','LIKE', $likevalue)
            ->orWhere('first', 'LIKE', $likevalue)
            ->limit(25)
            ->get()
            ->sortBy(['person.last','person.first']);
    }

    private function schools()
    {
        //early exit
        if(! strlen($this->searchschool)){ return collect(); }

        $likevalue = '%'.$this->searchschool.'%';

        return School::where('name','LIKE', $likevalue)
            ->limit(25)
            ->get()
            ->sortBy(['name', 'city']);
    }
}
