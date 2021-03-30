<?php

namespace App\Http\Livewire\School;

use App\Models\Geostate;
use App\Models\Gradetype;
use App\Models\Studio;
use App\Models\Tenure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class School extends Component
{
    public $message = 'Successful update!';

    public $school = NULL;
    public $schoolid = 0;
    public $searchresults = [];
    public $showAddModal = false;
    public $showEditModal = false;
    public $table_headers = ['Name', 'Location', 'Years', 'Actions'];
    public $table_schools = NULL;
    public $tenure = NULL;

    public $name = '';
    public $address01 = '';
    public $address02 = '';
    public $city = '';
    public $geostate_id = 0;
    public $postalcode = '';
    public $mailingaddress = '';

    public $startyear = 1960;
    public $endyear = 0;

    public $grades = []; //placeholder for user gradetype selections
    public $grades_found = false;

    //select options
    public $endyears = [];
    public $geostates = [];
    public $gradetypes = [];
    public $options = [];
    public $startyears = [];

    protected $rules = [
        'name' => ['required', 'min:5', 'max:60'],
        'address01' => ['string', 'nullable', 'max:120'],
        'address02' => ['string', 'nullable', 'max:120'],
        'city' => ['string', 'nullable', 'max:60'],
        'geostate_id' => ['required', 'integer'],
        'postalcode' => ['string', 'nullable', 'max:15'],
        'startyear' => ['required', 'integer'],
        'endyear' => ['integer', 'nullable'], //before:startyear if not null
        'schoolid' => ['nullable'],
        'searchresults' => ['nullable'],
        'grades_found' => ['nullable'],
    ];

    public function mount()
    {
        $this->searchresults = [];
        $this->table_schools = auth()->user()->schools;
        $this->geostates = $this->buildSimpleArrayFromCollection(Geostate::all(), 'id', 'abbr');
        $this->gradetypes = $this->buildSimpleArrayFromCollection(Gradetype::orderBy('orderby')->get(), 'id', 'descr');
        $this->options = $this->geostates;
        $this->startyears = $this->years();
        $this->endyears = $this->years(true);
        $this->setGrades();
        //initialize select values
        $this->geostate_id = array_key_first($this->geostates);
    }

    public function render()
    {
        return view('livewire.school.update-school-information-form');
    }

    public function add()
    {
        if(! $this->schoolid){

            $this->addNewSchool();

        }else {

            $this->validate([
                'startyear' => ['required', 'integer'],
                'endyear' => ['integer', 'nullable'],
            ]);
        }

        $this->school->users()->attach(auth()->id());

        Tenure::create([
            'user_id' => auth()->id(),
            'school_id' => $this->school->id,
            'startyear' => $this->startyear,
            'endyear' => $this->endyear,
        ]);

        $this->saveGrades();

        $this->table_schools = auth()->user()->schools;

        $this->cancelAdd();
    }

    public function cancelAdd()
    {
        $this->resetVars();
        $this->showAddModal = false;
    }

    public function delete($id)
    {
        DB::table('gradetype_school_user')
            ->where('school_id', '=', $id)
            ->where('user_id', '=', auth()->id())
            ->delete();

        \App\Models\School::find($id)->users()->detach(auth()->id());

        $this->table_schools = auth()->user()->schools;
    }

    public function edit($id)
    {
        $this->school = \App\Models\School::find($id);

        $this->tenure = Tenure::where('user_id', auth()->id())->where('school_id', $this->school->id)->first();

        $this->setGrades();

        $this->name = $this->school->name;
        $this->address01 = $this->school->address01;
        $this->address02 = $this->school->address02;
        $this->city = $this->school->city;
        $this->geostate_id = $this->school->geostate_id;
        $this->postalcode = $this->school->postalcode;
        $this->startyear = $this->tenure->startyear;
        $this->endyear = $this->tenure->endyear;

        $this->showEditModal = true;
    }

    public function loadSchool($school_id)
    {
        $this->schoolid = $school_id;
        $this->school = \App\Models\School::find($school_id);

        $this->name = $this->school->name;
        $this->mailingaddress = $this->school->mailingAddress;

        $this->tenure = Tenure::where('user_id', auth()->id())->where('school_id', $this->school->id)->first();

        $this->setGrades();

        $this->searchresults = [];
    }

    public function save()
    {
        $this->validate();

        $this->school->name = $this->name;
        $this->school->address01 = $this->address01;
        $this->school->address02 = $this->address02;
        $this->school->city = $this->city;
        $this->school->geostate_id = $this->geostate_id;
        $this->school->postalcode = $this->postalcode;
        $this->school->save();

        $this->tenure->startyear = $this->startyear;
        $this->tenure->endyear = $this->endyear;
        $this->tenure->save();

        $this->saveGrades();

        $this->showEditModal = false;
        $this->table_schools = auth()->user()->schools;

    }

    public function updateGrades($key)
    {
        $this->grades[$key] = (! $this->grades[$key]);

        $this->refreshGradesFound();
    }

    public function updatedName()
    {
        $this->searchresults = (strlen($this->name))
            ? $this->buildSearchLinks()
            : [];
    }

/** END OF PUBLIC FUNCTIONS  *************************************************/


    private function addNewSchool()
    {
        $this->validate();

        $this->school = \App\Models\School::create([
            'name' => $this->name,
            'address01' => $this->address01,
            'address02' => $this->address02,
            'city' => $this->city,
            'geostate_id' => $this->geostate_id,
            'postalcode' => $this->postalcode,
        ]);
    }

    private function buildSearchLinks()
    {
        $a = [];

        $collection = \App\Models\School::where('name', 'LIKE', '%'.$this->name.'%')->orderBy('name')->limit(5)->get();

        //early exit
        if(! $collection->count()){ return $a;}

        foreach($collection AS $school){ //ex. $a[#] = Ridge High School (Basking Ridge, NJ 07920)
            $a[$school->id] = $school->name.' ('.$school->city.', '.$school->geostateAbbr.' '.$school->postalcode.')';
        }

        return $a;
    }

    private function buildSimpleArrayFromCollection($batch, $keyname, $valuename)
    {
        $a = [];

        foreach($batch AS $item){
            $a[$item->$keyname] = $item->$valuename;
        }

        return $a;
    }

    private function findSchoolName() : \App\Models\School
    {
        return new \App\Models\School;
    }

    private function refreshGradesFound()
    {
        //if at least one grade is found, set $this->grades_found = true
        $this->grades_found = in_array(true, $this->grades);
    }

    private function resetVars()
    {
        $this->schoolid = 0;
        $this->school = NULL;
        $this->name = '';
        $this->address01 = '';
        $this->address02 = '';
        $this->city = '';
        $this->geostate_id = array_key_first($this->geostates);
        $this->postalcode = '';
        $this->startyear = 1960;
        $this->endyear = 0;
        $this->setGrades();
    }

    private function saveGrades()
    {
        $truecounter = 0;

        foreach($this->grades AS $key => $value)
        {
            if($value){$truecounter++;}

            auth()->user()->person->teacher->saveGradetype($this->school, $key, $value);
        }

        //refresh array
        $this->setGrades();
    }

    /**
     * Initialize $this->grades based on $this->gradetypes
     * AND current database values
     */
    private function setGrades()
    {
        //re-initialize var to false
        $this->grades_found = false;

        foreach($this->gradetypes AS $key => $value){

            $this->grades[$key] = ($this->school)
                ? auth()->user()->person->teacher->hasGradetype($this->school, $key)
                : false;

            $this->refreshGradesFound();
        }
    }

    /**
     * If years select box requires a blank option,
     * set $blankoption = true
     *
     * @param boolean $blankoption
     * @return array
     */
    private function years($blankoption=false)
    {
        $a = [];

        if($blankoption){$a[0] = '';}

        for($i=date('Y'); $i>1959; $i--){
            $a[$i] = $i;
        }

        return $a;
    }

}
