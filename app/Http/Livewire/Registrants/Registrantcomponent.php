<?php

namespace App\Http\Livewire\Registrants;

use App\Helpers\CollectionHelper;
use App\Models\Eventversion;
use App\Models\Registrant;
use App\Models\Userconfig;
use App\Models\Utility\Registrants;
use App\Models\Utility\Schoolregistrationstatus;
use Livewire\WithPagination;
use Livewire\Component;

class Registrantcomponent extends Component
{
    use WithPagination;

    //common contract properties for pages
    public $allowimports = true; //allow user to import ensemble members
    public $confirmingdelete = 0;
    public $membershipmanagers = [];
    public $perpage = 0; //pagination
    public $population = ''; //ALL members count
    public $search = '';
    public $selectall = false;
    public $selected = [];
    public $selectpage = 0;
    public $showaddmodal = false;
    public $showDeleteModal = false;
    public $showeditmodal = false;
    public $showfileuploadmodal = false;
    public $showfilters = false;
    public $sortdirection = 'asc';
    public $sortfield = '';

    //registrants-specific properties
    public $event = null; //shorthand for eventversion
    public $events = [];
    public $signatures = [];
    public $registrantstatus = "Click the student's status (Eligible, Applied, Registered) to display their
        status details here...";

    private $populations = ['eligible','applied','registered','hidden'];

    public function mount()
    {
        $this->event = Eventversion::find(Userconfig::getValue('eventversion', auth()->id()));
        $this->perpage = Userconfig::getValue('pagination', auth()->id());
        $this->population = Userconfig::getValue('registrantpopulation', auth()->id());
    }

    public function render()
    {
        return view('livewire.registrants.registrantcomponent',[
            'registrants' => $this->registrants(),
            'schoolregistrationstatus' => Schoolregistrationstatus::horizontalBarChart(),
        ]);
    }

    public function registrantstatus(Registrant $registrant)
    {
            $str = '<div class="bg-blue-700 p-2 rounded shadow">';

            $str .= '<div class="uppercase">'.$registrant->student->person->fullName.'</div>';
            $str .= '<div>Status: <b>'.ucwords($registrant->registranttypeDescr).'</b></div>';
            $str .= '<div>Application: <b>'
                .(($registrant->hasApplication) ? 'Downloaded' : 'None')
                .'</b></div>';
            $str .= '<div>Signatures: <b>'.(($registrant->hasSignatures) ? 'Signed' : 'Pending').'</b></div>';
            $str .= '<div>Files Uploaded: <b>'.($registrant->fileuploads()->count()).'</b> ('.$registrant->filesUploadedDescrCSV.')</div>';
            $str .= '<div>Files Approved: <b>'.($registrant->filesApprovedCount).'</b> ('.$registrant->filesApprovedDescrCSV.')</div>';

            $str .= '</div>';

            $this->registrantstatus = $str;
    }

    public function status()
    {
        $populations = [
            'eligible' => 'applied',
            'applied' => 'registered',
            'registered' => 'hidden',
            'hidden' => 'eligible',
        ];

        $this->population = $populations[$this->population];

        Userconfig::setValue('registrantpopulation', auth()->id(), $this->population);
    }

    public function updatedPerpage()
    {
        Userconfig::setValue('pagination', auth()->id(), $this->perpage);
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function registrants()
    {
        if($this->population === 'applied') {

            $this->populationregistrants = Registrants::applied($this->search);

        }elseif($this->population === 'registered'){

            $this->populationregistrants = Registrants::registered($this->search);

        }else{

            $this->populationregistrants = Registrants::eligible($this->search);
        }

        //paginate identified students
        return CollectionHelper::paginate($this->populationregistrants, Userconfig::getValue('pagination', auth()->id()));

    }


}
