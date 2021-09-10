<?php

namespace App\Http\Livewire\Siteadministration;

use App\Models\Membership;
use App\Models\Person;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Siteadministrator extends Component
{
    public $resetpasswordusername='';
    public $resetpasswordpassword='';
    public $search='';
    public $searchloginas='';
    public $searchschool='';
    public $searchuser='';
    //public $selectedschool=NULL;
    public $selectedschoolname='';
    public $students=NULL;
    public $teachers=NULL;

    private $selectedteachers=[];

    public function mount()
    {
        //$this->selectedschool = NULL;
        //$this->selectedschoolname = '';
        //$this->students=NULL;
        //$this->teachers=NULL;
    }

    public function render()
    {
        if(auth()->id() === 368) {
            return view('livewire.siteadministration.siteadministrator',
                [
                    'persons' => $this->persons(),
                    'schools' => $this->schools(),
                    'loginas' => $this->loginas(),
                    'users' => $this->users(),
                ]);
        }

        auth()->logout();
        return view('login');
    }

    public function switchLogin($value)
    {
        Auth::loginUsingId($value);
        // \Illuminate\Auth\RequestGuard::loginUsingId($value,true);
        //auth()->loginUsingId($value, true);

        $_SESSION['loginas'] = true;
    }

    public function transferStudents()
    {
        //2021-09-10
        //add filetypes for SJCDA, All-Shore
        $eventversions = [66,67,69];
        $filecontenttypes = [1,5,3]; //scales, solo, quartet
        $titles = [NULL,'solo','quartet'];

        foreach($eventversions AS $evid){

            foreach($filecontenttypes AS $key => $fctid){

                DB::table('eventversion_filecontenttype')
                    ->insert([
                        'eventversion_id' => $evid,
                        'filecontenttype_id' => $fctid,
                        'title' => $titles[$key],
                        'created_at' => '2021-09-10 17:50:50',
                        'updated_at' => '2021-09-10 17:50:50',
                    ]);
            }
        }

        //2021-09-09
        //add instrumentation for jr high chorus (ssaatb)
        /*
        $ids = [63,64,65,66,6,3];
        foreach($ids AS $key => $id) {
            DB::table('eventensembletype_instrumentation')
                ->insert([
                    'eventensembletype_id' => 18,
                    'instrumentation_id' => $id,
                    'order_by' => ($key + 1),
                    'created_at' => '2021-09-09 16:16:16',
                    'updated_at' => '2021-09-09 16:16:16'
                ]);
        }
        //add domain owner to SJCDA
        Membership::updateOrCreate(
            [
                'user_id' => 368,
                'organization_id' => 8,

            ],
            [
                'membershiptype_id' => 1,
                'membership_id' => 'sjcda',
                'expiration' => '2021-09-09',
                'grade_levels' => 'Secondary',
                'subject' => 'chorus',
            ]
        );
        */

        /*
        DB::table('eventversionconfigs')
            ->where('eventversion_id', '=', '65')
            ->update([
                'paypalteacher' => 0,
                'paypalstudent' => 0,
            ]);
        */
/*
        DB::table('eventversionconfigs')
            ->where('eventversion_id', '=', '65')
            ->update([
                'audiofiles' => 1,
                'virtualaudition' => 1,
            ]);

        DB::table('eventversionconfigs')
            ->where('eventversion_id', '=', '66')
            ->update([
                'eapplication' => 1,
                'audiofiles' => 1,
                'virtualaudition' => 1,
            ]);

        DB::table('eventversionconfigs')
            ->where('eventversion_id', '=', '67')
            ->update([
                'eapplication' => 1,
                'audiofiles' => 1,
                'virtualaudition' => 1,
            ]);

        DB::table('eventversionconfigs')
            ->where('eventversion_id', '=', '68')
            ->update([
                'eapplication' => 1,
                'virtualaudition' => 1,
                'audiofiles' => 1,
            ]);

        DB::table('eventversionconfigs')
            ->where('eventversion_id', '=', '69')
            ->update([
                'audiofiles' => 1,
                'virtualaudition' => 1,
            ]);
*/

        /*$studentuserids = [3610,3639,3583,3568,1267,3628,3561,2817];

        foreach($studentuserids AS $id){
            DB::table('student_teacher')
                ->where('student_user_id', '=', $id)
                ->where('teacher_user_id', '=', 54)
                ->update(['teacher_user_id' => 8495]);
        }*/

        //Kai Cleary for West Morris Central: Mark Stingle
        /*DB::table('school_user')
            ->insert([
                'user_id' => 8497,
                'school_id' => 3547
            ]);

        DB::table('student_teacher')
            ->insert([
                'student_user_id' => 8497,
                'teacher_user_id' =>324,
                'created_at' => '2021-09-07 07:48:00',
                'updated_at' => '2021-09-07 07:48:00'
            ]);
        */
    }

    public function updatePassword()
    {
        $user = User::where('username', $this->resetpasswordusername)->first();
        $user->forceFill([
            'password' => Hash::make($this->resetpasswordpassword),
        ])->save();
    }

    public function updateSchool($value)
    {
        $this->selectedschool = School::find($value);
        $this->selectedschoolname = ($this->selectedschool ? $this->selectedschool->name : '');
        $this->students = $this->selectedschool->currentStudents;
        $this->teachers = $this->selectedschool->teachersForTransfer();
        //$this->reset('searchschool');
    }

    public function updatedSearch($value)
    {
        //$this->reset(['selectedschool','selectedschoolname', 'teachers']);

        //$this->render();
    }

    public function updatedSearchloginas()
    {
        //dd('as: '.$this->searchloginas);
    }

    public function updatedSearchschool()
    {
        //$this->reset('search','selectedschool','selectedschoolname','selectedteachers','students','teachers');

        //$this->render();
    }

    public function updateSelectedTeachers($value)
    {
        $this->selectedteachers[] = $value;
    }

    private function loginas()
    {
        //early exit
        if(! strlen($this->searchloginas)){ return collect(); }

        $likevalue = '%'.$this->searchloginas.'%';

        return Person::where('last','LIKE', $likevalue)
            ->orWhere('first', 'LIKE', $likevalue)
            ->limit(25)
            ->get()
            ->sortBy(['person.last','person.first']);
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

    private function schools()
    {
        //early exit
        if(! strlen($this->searchschool)){ return collect(); }

        $likevalue = '%'.$this->searchschool.'%';

        return School::where('name','LIKE', $likevalue)
            ->limit(25)
            ->get()
            ->sortBy(['name', 'city']);
    }

    private function users()
    {
        //early exit
        if(! strlen($this->searchuser)){ return collect(); }

        $likevalue = '%'.$this->searchuser.'%';

        return User::where('username','LIKE', $likevalue)
            ->limit(25)
            ->get()
            ->sortBy(['username']);
    }


}
