<?php

namespace App\Http\Livewire\Students;

use App\Models\Emailtype;
use App\Models\Guardian;
use App\Models\Guardiantype;
use App\Models\Nonsubscriberemail;
use App\Models\Phone;
use App\Models\Phonetype;
use App\Models\Pronoun;
use Livewire\Component;

class Guardiancomponent extends Component
{
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
    public $editguardiantypeid = 1;
    public $guardians = null;
    public $student = null;

    protected $rules = [
        'editguardianfirst' => ['required', 'string'],
        'editguardianlast' => ['required', 'string'],
        'editguardianmiddle' => ['nullable', 'string'],
        'editguardianpronound_id' => ['required', 'integer'],
        'editguardiantypeid' => ['required', 'integer'],
    ];

    protected $validationAttributes = [
        'editguardianfirst' => 'first name',
        'editguardianlast' => 'last name',
        'editguardianmiddle' => 'middle name',
        'editguardianpronound_id' => 'preferred pronoun',
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
        dd($user_id);
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
        $this->editguardiantypeid = $this->editguardian->guardiantype()->id;

    }

    public function save()
    {
        $person = $this->editguardian->person;
        $person->first = $this->editguardianfirst;
        $person->middle = $this->editguardianmiddle;
        $person->last = $this->editguardianlast;
        $person->pronoun_id = $this->editguardianpronounid;
        $person->save();

        //update guardiantype_id pivot
        $this->editguardian->students()->updateExistingPivot($this->student->user_id,
            ['guardiantype_id' => $this->editguardiantypeid]);

        //emails


        $this->editguardian->refresh();
        $this->student->refresh();
        $this->guardians = $this->student->guardians;

        $this->emit('guardian-saved');
    }

    private function saveEmails()
    {
        $emails = [
            'personal' => ['obj' => null, 'emailtype_descr' => 'email_student_personal', 'current' => $this->emailpersonal,],
            'school' => ['obj' => null, 'emailtype_descr' => 'email_student_school', 'current' => $this->emailschool,],
        ];

        foreach ($emails as $email) {
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

    private function savePhones()
    {
        $phones = [
            'home' => ['obj' => null, 'phonetype_descr' => 'phone_student_home', 'current' => $this->phonehome,],
            'mobile' => ['obj' => null, 'phonetype_descr' => 'phone_student_mobile', 'current' => $this->phonemobile,],
        ];

        foreach ($phones as $phone) {
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


    private function stripPhone($str)
    {
        $chars = str_split($str);

        $ints = array_filter($chars, function($char){
            return is_numeric($char);
        });

        return implode($ints);
    }
}
