<?php

namespace App\Http\Livewire\Students;

use App\Models\Pronoun;
use App\Models\School;
use App\Models\Shirtsize;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Userconfig;
use App\Traits\SenioryearTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Studentroster extends Component
{
    use WithFileUploads,WithPagination,SenioryearTrait;

    public $classofs;
    public $countstudents=0;
    public $displayform = false;
    public $display_hide = true; //show the (def.) value
    public $filter;
    public $heights;
    public $photo = NULL;
    public $photo_stored = NULL;
    public $pronouns;
    public $schoolid;
    public $schools;
    public $search = '';
    public $shirtsizes;
    public $student = NULL;
    public $students = NULL;

    //student validated values
    public $birthday;
    public $classof;
    public $first;
    public $height;
    public $last;
    public $middle;
    public $pronoun_id;
    public $shirtsize_id;
    public $username;

    protected $validationAttributes = [
        'first' => 'first name',
        'last' => 'last name',
        'middle' => 'middle name'
    ];

    public function mount()
    {
        $this->filter = Userconfig::getValue('filter_studentroster', auth()->id());
        $this->classofs = $this->classofs();
        $this->heights = $this->heights();
        $this->pronouns = $this->pronouns();
        $this->schoolid = $this->getSchoolId();
        $this->schools = $this->schools();
        $this->shirtsizes = $this->shirtsizes();
    }

    public function render()
    {
        $this->students = $this->search();
        $this->countstudents = $this->students->count();

        return view('livewire.students.studentroster');
    }

    public function rules()
    {
        return [
            'birthday' => ['date', 'nullable'],
            'classof' => ['numeric', 'required','min:1960','max:'.(date('Y') + 12)],
            'first' => ['string', 'required', 'min:2','max:60',],
            'height' => ['integer', 'required', 'min:30','max:72'],
            'middle' => ['string', 'nullable', 'max:60',],
            'pronoun_id' => ['required', 'integer'],
            'last' => ['string', 'required', 'min:2', 'max:60',],
            'shirtsize_id' => ['required', 'integer'],
            'username' => ['string', 'required', 'min:3','max:61',Rule::unique('users')->ignore($this->student->user_id)],
        ];
    }

    /**
     * User is submitting the Biography form
     */
    public function biography()
    {
        $this->validate();

        $user = $this->student->person->user;
        $user->username = $this->username;
        if($this->photo){
            $user->profile_photo_path = $this->photo->store('public');
            //store('profile-photos') stores the file into storage/app/profile-photos directory.
        }

        $user->save();

        $user->refresh();

        $this->emit('saved-biography');
    }

    public function delete($id)
    {
        if($id === 'photo'){

            $this->student->person->user->profile_photo_path = NULL;
            $this->student->person->user->save();
        }
    }

    /**
     * User is submitting the Personal form
     */
    public function personal()
    {
        $this->validate();

        $person = $this->student->person;
        $person->first = $this->first;
        $person->middle = $this->middle;
        $person->last = $this->last;
        $person->pronoun_id = $this->pronoun_id;
        $person->save();

        $this->student->classof = $this->classof;
        $this->student->height = $this->height;
        $this->student->birthday = $this->birthday;
        $this->student->shirtsize_id = $this->shirtsize_id;
        $this->student->save();

        $this->student->refresh();

        $this->emit('saved-personal');
    }

    public function savePhoto()
    {
        $this->validate([
            'photo' => ['image', 'max:1024',],
        ]);

        $this->photo->store('test-photos');
    }

    public function studentForm($user_id)
    {
        //re-initialize to prevent display when next-student is edited
        $this->photo = NULL;

        //display the form
        $this->displayform = true;

        $this->student = Student::with('person')->find($user_id);
        $this->birthday = $this->student->birthday;
        $this->classof = $this->student->classof;
        $this->first = $this->student->person->first;
        $this->height = $this->student->height;
        $this->last = $this->student->person->last;
        $this->middle = $this->student->person->middle;
        $this->pronoun_id = $this->student->person->pronoun_id;
        $this->shirtsize_id = $this->student->shirtsize_id;
        $this->username = $this->student->person->user->username;
    }

    public function updatedFilter()
    {
        Userconfig::setValue('filter_studentroster', auth()->id(), $this->filter);
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => ['image', 'max:1024',],
        ]);
    }

    public function updatedSchoolid()
    {
        $this->getSchoolId();
    }


/** END OF PUBLIC FUNCTIONS **************************************************/

    /**
     * @todo test with primary or middle school teacher
     * @todo redefine algorithm with collegiate/adult grades
     *
     * Return an array [classof => grade||classof]
     * array key=>value pairs consist of
     * - all grades taught by auth()->id() at the current school
     * AND
     * - all classofs since auth()->id() has been teaching at the current school
     * ex.
     * [
     *  2024 => 9,
     *  2023 => 10,
     *  2022 => 11,
     *  2021 => 12,
     *  2020 => 2020,
     *  2019 => 2019,
     *  2018 => 2018,
     * ]
     * @return array
     */
    private function classofs() : array
    {
        //what is the current senior year
        $senioryear = $this->senioryear();

        //what school is being targeted
        $school = School::find(Userconfig::getValue('school_id', auth()->id()));

        //what grades are taught at the school for this teacher
        $grades = $school->currentUserGrades;

        $a = [];

        //register the current grades
        foreach($grades AS $grade){
            $classof = ($senioryear + (12 - $grade));
            $a[$classof] = $grade;
        }

        //how long as this teacher been teaching at the targeted school
        $teacher = Teacher::find(auth()->id());
        $tenures = $teacher->tenures->where('school_id', $school->id);

        //register the alum grades
        foreach($tenures AS $tenure){
            for($i=$tenure->startyear; $i<=$tenure->endyear; $i++){
                if(! array_key_exists($i, $a)){
                    $a[$i] = $i;
                }
            }
        }
        //sort from high-to-low classofs keys (ex.2024,2023,2022,2021,etc)
        krsort($a);

        return $a;
    }

    public function footInches($inches)
    {
        return floor($inches / 12)."' ".($inches % 12).'"';
    }

    private function getSchoolId()
    {
        //fetch the value from the current value from the database
        $stored = Userconfig::getValue('school_id', auth()->id());

        //initialize $this->>schoolid
        if(! $this->schoolid){ $this->schoolid = $stored;}

        //early exit
        if($stored === $this->schoolid){ return $stored;} //return the stored value

        //$this->schoolid has been changed; register and return the new value
        Userconfig::setValue('school_id', auth()->id(), $this->schoolid);

        //return the newly stored value (recursive function)
        self::getSchoolId();
    }

    private function heights()
    {
        $a = [];

        for($i=30; $i < 94; $i++){
            $a[$i] = $i.' ('.$this->footInches($i).')';
        }

        return $a;
    }

    private function pronouns()
    {
        $a = [];

        foreach(Pronoun::orderBy('order_by')->get() AS $pronoun){
            $a[$pronoun->id] = $pronoun->descr;
        }

        return $a;
    }

    private function schools()
    {
        $a = [];
        $user = User::find(auth()->id());

        foreach($user->schools AS $school){

            $a[$school->id] = $school->name;
        }

        asort($a);

        return $a;
    }

    private function search()
    {
        $teacher = Teacher::find(auth()->id());
        return $teacher->students($this->search);
    }

    private function shirtsizes()
    {
        $a = [];

        foreach(Shirtsize::orderBy('order_by')->get() AS $shirtsize){
            $a[$shirtsize->id] = $shirtsize->abbr.' ('.$shirtsize->descr.')';
        }

        return $a;
    }



}
