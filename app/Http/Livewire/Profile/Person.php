<?php

namespace App\Http\Livewire\Profile;

use App\Models\Honorific;
use App\Models\Pronoun;
use Livewire\Component;

class Person extends Component
{
    private $person;

    public $first_name;
    public $honorific_id;
    public $honorifics;
    public $last_name;
    public $middle_name;
    public $pronoun_id;
    public $pronouns;
    public $success;

    protected $rules= [
        'first_name' => ['required','string'],
        'honorific_id' => ['required', 'numeric'],
        'last_name' => ['required', 'string'],
        'middle_name' => ['nullable','string'],
        'pronoun_id' => ['required','numeric'],
        ];

    public function mount()
    {
        $this->first_name = auth()->user()->person->first_name;
        $this->middle_name = auth()->user()->person->middle_name;
        $this->last_name = auth()->user()->person->last_name;

        $this->honorifics = Honorific::orderBy('order_by')->get();
        $this->honorific_id = auth()->user()->person->honorific_id;

        $this->pronouns = Pronoun::orderBy('order_by')->get();
        $this->pronoun_id = auth()->user()->person->pronoun_id;

        $this->success = false;
    }

    public function render()
    {
        return view('livewire.profile.person-form');
    }

    public function save()
    {
        \App\Models\Person::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'honorific_id' => $this->honorific_id,
                'pronoun_id' => $this->pronoun_id,
            ]
        );

        //add event here for searchables

        $this->success = 'Your personal information has been updated!';
    }
}
