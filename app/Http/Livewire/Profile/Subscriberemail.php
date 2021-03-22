<?php

namespace App\Http\Livewire\Profile;

use App\Models\Emailtype;
use App\Models\Searchable;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Subscriberemail extends Component
{
    public $email_other;
    public $email_personal;
    public $email_work;
    public $user;
    public $message = 'Your email records have been updated!';

    protected $rules= [
        'email_other' => ['email', 'min:1', 'max:255','different:email_personal','different:email_work'],
        'email_personal' => ['email', 'min:1', 'max:255','different:email_other','different:email_work'],
        'email_work' => ['email', 'min:1', 'max:255','different:email_other','different:email_personal'],
    ];

    public function mount()
    {
        $this->email_other = $this->email('other');
        $this->email_personal = $this->email('personal');
        $this->email_work = $this->email('work');
    }


    public function render()
    {
        return view('livewire.profile.subscriberemail-form');
    }

    public function save()
    {
        $this->validate([
            'email_other' => ['email', 'min:1', 'max:255','different:email_personal','different:email_work',
                Rule::unique('subscriberemails','email')->ignore(auth()->id(), 'user_id')],
            'email_personal' => ['email', 'min:1', 'max:255','different:email_other','different:email_work',
                Rule::unique('subscriberemails','email')->ignore(auth()->id(), 'user_id')],
            'email_work' => ['email', 'min:1', 'max:255','different:email_other','different:email_personal',
                Rule::unique('subscriberemails','email')->ignore(auth()->id(), 'user_id')],
        ]);

        $descrs = ['other', 'personal', 'work'];

        //cycle through each email type
        for($i=0; $i<count($descrs); $i++){

            //define the related variable (ex. $this->email_work)
            $label = 'email_'.$descrs[$i];

            //define the attributes for updateOrCreate() and delete() functions
            $attributes = [
                'user_id' => auth()->id(),
                'emailtype_id' => Emailtype::where('descr', $descrs[$i])->first()->id,
                ];

            //if an email address exists, updateOrCreate table row
            if($this->$label) {
                \App\Models\Subscriberemail::updateOrCreate(
                    $attributes,
                    ['email' => $this->$label,],
                );

                //add hashed value to searchables table
                $s = new Searchable;
                $s->add(auth()->user(),$label, $this->$label);

            }else{ //delete table row if it exists
                $s = new Searchable;
                $s->remove(auth()->user(), $label);
                \App\Models\Subscriberemail::where($attributes)->delete();
            }
        }

        //emit $this->message
        $this->emit('saved');
    }

    private function email($descr) : string
    {
        return auth()->user()->person->subscriberemails
            ->where('emailtype_id',
                Emailtype::where('descr', $descr)->first()->id)
            ->first()
            ->email ?? '';
    }
}
