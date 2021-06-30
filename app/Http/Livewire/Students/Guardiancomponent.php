<?php

namespace App\Http\Livewire\Students;

use App\Models\Emailtype;
use App\Models\Guardian;
use App\Models\Guardiantype;
use App\Models\Nonsubscriberemail;
use App\Models\Person;
use App\Models\Phone;
use App\Models\Phonetype;
use App\Models\Pronoun;
use App\Models\User;
use App\Traits\StoreCommunicationObject;
use App\Traits\UsernameTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Component;

class Guardiancomponent extends Component
{
    use StoreCommunicationObject, UsernameTrait;

    public $addguardian = false;
    public $confirmingdelete = false;
    public $editguardian = null;
    public $editguardianemailalternate = '';
    public $editguardianemailprimary = '';
    public $editguardianfirst = '';
    public $editguardianlast = '';
    public $editguardianmiddle = '';
    public $editguardianphonehome = '';
    public $editguardianphonemobile = '';
    public $editguardianphonework = '';
    public $editguardianpronounid = 1;
    public $editguardiantype = null;
    public $editguardiantypeid = 1;
    public $guardians = null;
    public $searchname = '';
    public $similarnames = '';
    public $student = null;

    protected $rules = [
        'editguardianfirst' => ['required', 'string'],
        'editguardianlast' => ['required', 'string'],
        'editguardianmiddle' => ['nullable', 'string'],
        'editguardianpronounid' => ['required', 'integer'],
        'editguardiantypeid' => ['required', 'integer'],
    ];

    protected $validationAttributes = [
        'editguardianfirst' => 'first name',
        'editguardianlast' => 'last name',
        'editguardianmiddle' => 'middle name',
        'editguardianpronounid' => 'preferred pronoun',
        'editguardiantypeid' => 'parent/guardian type',
    ];

    public function mount()
    {
        $this->guardians = $this->student->guardians;
    }

    public function render()
    {
        return view('livewire.students.guardiancomponent',
        [
            'pronouns' => Pronoun::all(),
            'guardiantypes' => Guardiantype::all(),
            'guardians' => $this->student->guardians,
        ]);
    }

    public function delete($user_id)
    {
        if($this->confirmingdelete) {
            $this->student->guardians()->detach($user_id);
            $this->student->refresh();
            $this->editguardian = null;
            $this->guardians = $this->student->guardians;
            $this->confirmingdelete = false;
        }else{

            $this->confirmingdelete = $user_id;
        }
    }

    public function edit($user_id)
    {
        $this->guardians = $this->student->guardians;

        $this->editguardian = $this->guardians->where('user_id', $user_id)->first();

        $this->editguardianemailalternate = $this->editguardian->emailAlternate->id ? $this->editguardian->emailAlternate->email : '';
        $this->editguardianemailprimary = $this->editguardian->emailPrimary->id ? $this->editguardian->emailPrimary->email : '';
        $this->editguardianfirst = $this->editguardian->person->first;
        $this->editguardianlast = $this->editguardian->person->last;
        $this->editguardianmiddle = $this->editguardian->person->middle ;
        $this->editguardianphonehome = $this->editguardian->phoneHome->id ? $this->editguardian->phoneHome->phone : '';
        $this->editguardianphonemobile = $this->editguardian->phoneMobile->id ? $this->editguardian->phoneMobile->phone : '';
        $this->editguardianphonework = $this->editguardian->phoneWork->id ? $this->editguardian->phoneWork->phone : '';
        $this->editguardianpronounid = $this->editguardian->person->pronoun_id;
        $this->editguardiantypeid = $this->editguardian->guardiantype($this->student->user_id)->id;
        $this->editguardiantype = Guardiantype::find($this->editguardiantypeid);

    }

    public function save()
    {
        $this->validate();

        //update existing guardian
        if($this->editguardian && $this->editguardian->user_id) { //update existing Guardian object

            $this->update();

        }else{ //or create a new guardian

            $this->store();
        }

        //what to do if failure to create a new guardian
        if(! $this->editguardian) { //may be false if $this->store() fails

            $this->editguardian = null;

            $this->emit('guardian-failed');

        }else{ //continue updating or inserting guardian components

            //emails and phones
            $this->updateOrCreateCommunicationObjects();

            //refresh objects
            $this->editguardian->refresh();
            $this->student->refresh();
            $this->guardians = $this->student->guardians;

            //refresh individual editguardian* properties
            $this->edit($this->editguardian->user_id);

            $this->emit('guardian-saved');
        }
    }

    public function updatedAddguardian()
    {
        $this->editguardian = new Guardian;

        $this->editguardianemailalternate = '';
        $this->editguardianemailprimary = '';
        $this->editguardianfirst = '';
        $this->editguardianlast = '';
        $this->editguardianmiddle = '';
        $this->editguardianphonehome = '';
        $this->editguardianphonemobile = '';
        $this->editguardianphonework = '';
        $this->editguardianpronounid = 1;
        $this->editguardiantypeid = 1;
    }

    public function updatedEditguardianfirst()
    {
        $this->searchForDuplicate();
    }

    public function updatedEditguardianlast()
    {
        $this->searchForDuplicate();
    }

    private function updateOrCreateCommunicationObjects()
    {
        //emails
        $this->saveEmails('email_guardian_alternate', $this->editguardianemailalternate, $this->editguardian->user_id);
        $this->saveEmails('email_guardian_primary', $this->editguardianemailprimary, $this->editguardian->user_id);

        //phones
        $this->savePhones('phone_guardian_home', $this->editguardianphonehome, $this->editguardian->user_id);
        $this->savePhones('phone_guardian_mobile', $this->editguardianphonemobile, $this->editguardian->user_id);
        $this->savePhones('phone_guardian_work', $this->editguardianphonework, $this->editguardian->user_id);
    }

    private function update()
    {
        //update person data
        $person = $this->editguardian->person;
        $person->first = $this->editguardianfirst;
        $person->middle = $this->editguardianmiddle;
        $person->last = $this->editguardianlast;
        $person->pronoun_id = $this->editguardianpronounid;
        $person->save();

        //update guardiantype_id pivot
        $this->editguardian->students()->updateExistingPivot($this->student->user_id,
            ['guardiantype_id' => $this->editguardiantypeid]);
    }

    /**
     * @todo build failsafes for avoiding duplicate entries on guardians
     *  - ex. compare/validate last name, email, phone numbers before saving
     */
    private function searchForDuplicate()
    {
        $persons = Person::where('first', 'LIKE','%'.$this->editguardianfirst.'%')
            ->where('last','LIKE','%'.$this->editguardianlast.'%')
            ->get()
            ->sortBy('last')
            ->sortBy('first')
            ->sortByDesc('middle');
        if($persons->count()){
            $this->similarnames = '<h4>'.$persons->count().' similar Guardian/Parents found</h4>';
            $this->similarnames .= '<ul>';
            foreach($persons AS $person){

                $this->similarnames .= '<li>'.$person->fullNameAlpha.'</li>';
            }
            $this->similarnames .= '</ul>';
        }
    }

    private function store()
    {
        //early exit
        if($this->searchForDuplicate()){ $this->editguardian = null; }

        $user = User::create([
            'username' => $this->username($this->editguardianfirst, $this->editguardianlast),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),]);

        Person::create([
            'user_id' => $user->id,
            'first' => $this->editguardianfirst,
            'middle' => $this->editguardianmiddle,
            'last' => $this->editguardianlast,
            'pronoun_id' => $this->editguardianpronounid,
        ]);

        $guardian = Guardian::create([
            'user_id' => $user->id,
        ]);

        /** Workaround because $guardian always returns model with user_id === 0 */
        $this->editguardian = Guardian::find($user->id);
        $this->editguardian->students()->attach($this->student->user_id,
            ['guardiantype_id' => $this->editguardiantypeid]);
        $this->editguardian->refresh();

    }
}
