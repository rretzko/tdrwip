<?php

namespace App\Http\Livewire\Students;

use App\Models\Instrumentationbranch;
use App\Models\Pronoun;
use App\Models\School;
use App\Models\Shirtsize;
use App\Traits\SenioryearTrait;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Userconfig;
use App\Traits\FormatPhoneTrait;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Studentrostertabbed extends Component
{
    use FormatPhoneTrait,SenioryearTrait,WithFileUploads;

    public $birthday;
    public $classof;
    public $classofs;
    public $displayform = false;
    public $displayhide;
    public $countstudents;
    public $filter;
    public $first;
    public $height;
    public $heights;
    public $last;
    public $middle;
    public $photo = NULL;
    public $pronouns;
    public $pronoun_id;
    public $schools;
    public $search;
    public $shirtsizes;
    public $shirtsize_id;
    public $student = NULL;
    public $students;
    public $tab;
    public $tabcontent;
    public $teacher;
    public $username;

    public function mount()
    {
        $this->classofs = $this->classofs();
        $this->displayhide = Userconfig::getValue('pagedef_students', auth()->id());
        $this->filter = Userconfig::getValue('filter_studentroster', auth()->id());
        $this->heights = $this->heights();
        $this->pronouns = $this->pronouns();
        $this->schools = $this->schools();
        $this->shirtsizes = $this->shirtsizes();
        $this->tab = Userconfig::getValue('studentform_tab', auth()->id());
        /*
        $this->choralinstrumentation = $this->instrumentationChoral();
        $this->guardians = $this->guardians();
        $this->guardiantypes = $this->guardianTypes();
        $this->geostates = $this->geostates();
        $this->honorifics = $this->honorifics();
        $this->instrumentalinstrumentation = $this->instrumentationInstrumental();
        $this->instrumentationbranches = Instrumentationbranch::where('id', '<', 3)->get();
        $this->newinstrumentations = collect(); //$this->newInstrumentations();
        $this->schoolid = $this->getSchoolId();
        $this->schools = $this->schools();
        */
    }

    public function render()
    {
        $this->students = $this->search();
        $this->countstudents = $this->students->count();
        $this->teacher = Teacher::with(['person', 'person.user','person.honorific', ])->find(auth()->id());

        return view('livewire.students.studentrostertabbed',[]);
    }

    public function rules()
    {
        return [
            'address01' => ['string', 'nullable'],
            'address02' => ['string', 'nullable'],
            'city' => ['string', 'nullable'],
            'emailpersonal' => ['email', 'nullable'],
            'emailschool' => ['email', 'nullable'],
            'geostate_id' => ['integer', 'nullable','exists:geostates,id','min:1'],
            //'birthday' => ['date', 'nullable'],
            //'classof' => ['numeric', 'required','min:1960','max:'.(date('Y') + 12)],
            //'first' => ['string', 'required', 'min:2','max:60',],
            //'height' => ['integer', 'required', 'min:30','max:72'],
            //'middle' => ['string', 'nullable', 'max:60',],
            //'pronoun_id' => ['required', 'integer', 'min:1'],
            //'last' => ['string', 'required', 'min:2', 'max:60',],
            //'shirtsize_id' => ['required', 'integer', 'min:1'],
            'instrumentation_id' => ['numeric', 'min:1'],
            'instrumentationbranch_id' => ['numeric', 'min:1'],
            'phonehome' => ['string', 'nullable',],
            'phonemobile' => ['string', 'nullable','min:10'],
            'postalcode' => ['string', 'nullable','min:5'],
            // 'username' => ['string', 'required', 'min:3','max:61',Rule::unique('users')->ignore($this->student->user_id ?? 0)],
        ];
    }

    public function editStudentForm($user_id)
    {
        $this->student = Student::find($user_id);

        $this->username = $this->student->person->user->username;

        $this->classof = $this->student->classof;
        $this->first = $this->student->person->first;
        $this->height = $this->student->height;
        $this->last = $this->student->person->last;
        $this->middle = $this->student->person->middle;
        $this->pronoun_id = $this->student->person->pronoun_id;

        $this->birthday = $this->student->birthday;
        $this->shirtsize_id = $this->student->shirtsize_id;

        //final action
        $this->displayform = true;
    }

    public function footInches($inches)
    {
        return floor($inches / 12)."' ".($inches % 12).'"';
    }

    public function updatedTab()
    {
        //persist user's selection
        Userconfig::setValue('studentform_tab', auth()->id(), $this->tab);

        $this->tabcontent = Userconfig::getValue('studentform_tab', auth()->id());
    }

    /**
     * User is submitting the Biography form
     */
    public function updateBiography()
    {
        $this->validate([
            'username' => ['string', 'required', 'min:3','max:61',Rule::unique('users')->ignore($this->student->user_id ?? 0)],
        ]);

        $user = $this->student->person->user;
        $user->username = $this->username;

        if($this->photo){
            $user->profile_photo_path = $this->photo->store('public');
            //store('profile-photos') stores the file into storage/app/profile-photos directory.
        }

        $user->save();

        $this->photo = '';

        $user->refresh();

        $this->emit('saved-biography');
    }

    /**
     * User is submitting the Profile form
     */
    public function updateProfile()
    {
        $this->validate([
            'birthday' => ['date', 'nullable'],
            'classof' => ['numeric', 'required','min:1960','max:'.(date('Y') + 12)],
            'first' => ['string', 'required', 'min:2','max:60',],
            'height' => ['integer', 'required', 'min:30','max:72'],
            'middle' => ['string', 'nullable', 'max:60',],
            'pronoun_id' => ['required', 'integer', 'min:1'],
            'last' => ['string', 'required', 'min:2', 'max:60',],
            'shirtsize_id' => ['required', 'integer', 'min:1'],
        ]);

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

    public function updatedDisplayhide()
    {
        Userconfig::setValue('pagedef_students', auth()->id(), $this->displayhide);
    }

    public function updatedFilter()
    {
        Userconfig::setValue('filter_studentroster', auth()->id(), $this->filter);
    }

}
