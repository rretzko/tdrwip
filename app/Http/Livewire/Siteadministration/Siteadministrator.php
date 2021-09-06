<?php

namespace App\Http\Livewire\Siteadministration;

use App\Models\Person;
use Livewire\Component;

class Siteadministrator extends Component
{
    public $search='';

    public function updatedSearch($value)
    {
        $this->render();
    }

    public function render()
    {
        return view('livewire.siteadministration.siteadministrator',
        [
            'persons' => $this->persons(),
        ]);
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
}
