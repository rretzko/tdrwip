<?php

namespace App\Http\Livewire\Students;

use App\Models\Address;
use App\Models\Emailtype;
use App\Models\Geostate;
use App\Models\Instrumentation;
use App\Models\Instrumentationbranch;
use App\Models\Nonsubscriberemail;
use App\Models\Phone;
use App\Models\Phonetype;
use App\Models\Pronoun;
use App\Models\School;
use App\Models\Shirtsize;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Userconfig;
use App\Traits\FormatPhoneTrait;
use App\Traits\SenioryearTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Studentroster extends Component
{
    use FormatPhoneTrait,WithFileUploads,WithPagination,SenioryearTrait;

    public $choralinstrumentation;
    public $classofs;
    public $countstudents=0;
    public $displayform = false;
    public $display_hide = true; //show the (def.) value
    public $filter;
    public $geostates;
    public $guardians;
    public $heights;
    public $instrumentalinstrumentation;
    public $instrumentationbranch_id = 0;
    public $instrumentationbranches;
    public $instrumentationbranch;
    public $instrumentations;
    public $instrumentation_id = 0;
    public $photo = NULL;
    public $photo_stored = NULL;
    public $newinstrumentations;
    public $pronouns;
    public $schoolid;
    public $schools;
    public $search = '';
    public $shirtsizes;
    public $showmodal = false;
    public $student = NULL;
    public $students = NULL;
    public $teacher = NULL;
    public $addinstrument = false;

    //student validated values
    public $address01;
    public $address02;
    public $birthday;
    public $city;
    public $classof;
    public $emailpersonal;
    public $emailschool;
    public $first;
    public $geostate_id;
    public $height;
    public $last;
    public $middle;
    public $phonehome;
    public $phonemobile;
    public $postalcode;
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
        //ex. all,alum,current
        $this->filter = Userconfig::getValue('filter_studentroster', auth()->id());

        $this->choralinstrumentation = $this->choralInstrumentation();
        $this->classofs = $this->classofs();
        $this->guardians = $this->guardians();
        $this->geostates = $this->geostates();
        $this->heights = $this->heights();
        $this->instrumentalinstrumentation = $this->instrumentalInstrumentation();
        $this->instrumentationbranches = Instrumentationbranch::where('id', '<', 3)->get();
        $this->newinstrumentations = collect(); //$this->newInstrumentations();
        $this->pronouns = $this->pronouns();
        $this->schoolid = $this->getSchoolId();
        $this->schools = $this->schools();
        $this->shirtsizes = $this->shirtsizes();
    }

    public function render()
    {
        $this->students = $this->search();
        $this->countstudents = $this->students->count();
        $this->teacher = Teacher::with(['person', 'person.user','person.honorific', ])->find(auth()->id());

        return view('livewire.students.studentroster',[]);
    }

    public function rules()
    {
        return [
            'address01' => ['string', 'nullable'],
            'address02' => ['string', 'nullable'],
            'birthday' => ['date', 'nullable'],
            'city' => ['string', 'nullable'],
            'classof' => ['numeric', 'required','min:1960','max:'.(date('Y') + 12)],
            'emailpersonal' => ['email', 'nullable'],
            'emailschool' => ['email', 'nullable'],
            'first' => ['string', 'required', 'min:2','max:60',],
            'geostate_id' => ['integer', 'nullable','exists:geostates,id','min:1'],
            'height' => ['integer', 'required', 'min:30','max:72'],
            'instrumentation_id' => ['numeric', 'min:1'],
            'instrumentationbranch_id' => ['numeric', 'min:1'],
            'middle' => ['string', 'nullable', 'max:60',],
            'phonehome' => ['string', 'nullable',],
            'phonemobile' => ['string', 'nullable','min:10'],
            'postalcode' => ['string', 'nullable','min:5'],
            'pronoun_id' => ['required', 'integer', 'min:1'],
            'last' => ['string', 'required', 'min:2', 'max:60',],
            'shirtsize_id' => ['required', 'integer', 'min:1'],
            'username' => ['string', 'required', 'min:3','max:61',Rule::unique('users')->ignore($this->student->user_id ?? 0)],
        ];
    }

    public function closeModal()
    {
        $this->showmodal = false;
    }

    public function createInstrumentation()
    {
        $this->showmodal = true;
        $this->instrumentation_id = null;
        $this->instrumentationbranch_id = null;
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

    public function contacts()
    {
        $this->validate();

        $this->contactsEmails();

        $this->contactsPhones();

        $this->student->refresh();

        $this->emit('saved-contacts');
    }

    /**
     * Delete photo
     * @param $id
     */
    public function delete($id)
    {
        if($id === 'photo'){

            $this->student->person->user->profile_photo_path = NULL;
            $this->student->person->user->save();
        }

        if($id === 'instrumentation'){
            //do nothing
        }
    }

    public function deleteInstrumentation($id)
    {
        $this->student->person->user->instrumentations()->detach($id);

        $this->student->refresh();
    }

    public function footInches($inches)
    {
        return floor($inches / 12)."' ".($inches % 12).'"';
    }

    public function guardian()
    {
        $this->emit('saved-guardian');
    }

    public function homeAddress()
    {
        $this->validate([
            'address01' => ['string', 'nullable'],
            'address02' => ['string', 'nullable'],
            'city' => ['string', 'nullable'],
            'geostate_id' => ['integer', 'nullable','exists:geostates,id','min:1'],
            'postalcode' => ['string', 'nullable','min:5'],
        ]);

        $model = Address::updateOrCreate([
                'user_id' => $this->student->user_id
            ],
            [
                'address01' => $this->address01,
                'address02' => $this->address02,
                'city' => $this->city,
                'geostate_id' => $this->geostate_id,
                'postalcode' => $this->postalcode,
            ]
        );

        $this->student->person->user->address->refresh();

        $this->emit('saved-homeaddress');
    }

    public function instrumentations()
    {
        $this->validate();

        $this->student->person->user->instrumentations()->attach($this->instrumentation_id, ['order_by' => 1]);

        $this->choralInstrumentation();
        $this->instrumentalInstrumentation();

        $this->emit('saved-instrumentations');
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

    public function storeInstrumentation()
    {
        $this->validate();

        $this->student->person->user->instrumentations()->attach($this->instrumentation_id, ['order_by' => 1]);

        $this->student->refresh();
        $this->choralInstrumentation();
        $this->instrumentalInstrumentation();

        $this->closeModal();
    }

    public function studentForm($user_id)
    {
        //re-initialize to prevent display when next-student is edited
        $this->photo = NULL;

        //display the form
        $this->displayform = true;

        $this->student = Student::with('person')->find($user_id);

        $this->address01 = $this->student->person->user->address->address01;
        $this->address02 = $this->student->person->user->address->address02;
        $this->birthday = $this->student->birthday;
        $this->choralinstrumentation = $this->choralInstrumentation();
        $this->city = $this->student->person->user->address->city;
        $this->classof = $this->student->classof;
        $this->emailpersonal = $this->student->emailPersonal->id ? $this->student->emailPersonal->email : '';
        $this->emailschool = $this->student->emailSchool->id ? $this->student->emailSchool->email : '';
        $this->first = $this->student->person->first;
        $this->geostate_id = $this->student->person->user->address->geostate_id;
        $this->guardians = $this->guardians();
        $this->height = $this->student->height;
        $this->instrumentalinstrumentation = $this->instrumentalInstrumentation();
        $this->last = $this->student->person->last;
        $this->middle = $this->student->person->middle;
        $this->phonehome = $this->student->phoneHome->id ? $this->student->phoneHome->phone : '';
        $this->phonemobile = $this->student->phoneMobile->id ? $this->student->phoneMobile->phone : '';
        $this->postalcode = $this->student->person->user->address->postalcode;
        $this->pronoun_id = $this->student->person->pronoun_id;
        $this->shirtsize_id = $this->student->shirtsize_id;
        $this->username = $this->student->person->user->username;
    }

    public function updatedFilter()
    {
        Userconfig::setValue('filter_studentroster', auth()->id(), $this->filter);
    }

    public function updatedInstrumentationbranch($value)
    {
        $this->newinstrumentations = $this->newInstrumentations();
        $this->instrumentationbranch_id = $value;
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

    public function updatedPhonehome()
    {
        $this->phonehome = (strlen($this->phonehome)) ? $this->formatPhone($this->phonehome) : '';
    }

    public function updatedPhonemobile()
    {
        $this->phonemobile = (strlen($this->phonemobile)) ? $this->formatPhone($this->phonemobile) : '';
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function choralInstrumentation()
    {
        //early exist
        if(! $this->student){ return collect();}

        return $this->student->person->user->instrumentations()->where('instrumentationbranch_id', Instrumentationbranch::where('descr', 'choral')->first()->id)->get();
    }

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

    private function contactsEmails()
    {
        $emails = [
            'personal' => ['obj' => NULL, 'emailtype_descr' => 'email_student_personal', 'current' => $this->emailpersonal,],
            'school' => ['obj' => NULL, 'emailtype_descr' => 'email_student_school', 'current' => $this->emailschool,],
        ];

        foreach($emails AS $email) {
            $email['obj'] = Nonsubscriberemail::firstOrCreate(
                [
                    'user_id' => $this->student->user_id,
                    'emailtype_id' => Emailtype::where('descr', $email['emailtype_descr'])->first()->id,
                ],
                [
                    'email' => $email['current'],
                ]
            );

            //update object if user's input differs from current record
            if ($email['current'] !== $email['obj']->email) {

                $email['obj']->email = $email['current'];
                $email['obj']->save();
            }
        }
    }

    private function contactsPhones()
    {
        $phones = [
            'home' => ['obj' => NULL, 'phonetype_descr' => 'phone_student_home', 'current' => $this->phonehome,],
            'mobile' => ['obj' => NULL, 'phonetype_descr' => 'phone_student_mobile', 'current' => $this->phonemobile,],
        ];

        foreach($phones AS $phone) {
            $phone['obj'] = Phone::firstOrCreate(
                [
                    'user_id' => $this->student->user_id,
                    'phonetype_id' => Phonetype::where('descr', $phone['phonetype_descr'])->first()->id,
                ],
                [
                    'phone' => $phone['current'],
                ]
            );

            //update object if user's input differs from current record
            if ($phone['current'] !== $phone['obj']->phone) {

                $phone['obj']->phone = $phone['current'];
                $phone['obj']->save();
            }
        }
    }

    private function geostates()
    {
        $a = [];

        foreach(Geostate::all() AS $geostate){

            $a[$geostate->id] = $geostate->abbr;
        }

        return $a;
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

    private function guardians()
    {
        return collect();
    }

    private function heights()
    {
        $a = [];

        for($i=30; $i < 94; $i++){
            $a[$i] = $i.' ('.$this->footInches($i).')';
        }

        return $a;
    }

    private function instrumentalInstrumentation()
    {
        //early exist
        if(! $this->student){ return collect();}

        return $this->student->person->user->instrumentations()->where('instrumentationbranch_id',Instrumentationbranch::where('descr','instrumental')->first()->id)->get();
    }

    public function newInstrumentations()
    {
        return Instrumentation::where('instrumentationbranch_id', $this->instrumentationbranch)->get()->sortBy('descr');
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
