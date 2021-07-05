<?php

namespace App\Imports;

use App\Http\Controllers\UserconfigController;
use App\Models\Ensemble;
use App\Models\Instrumentation;
use App\Models\Person;
use App\Models\Schoolyear;
use App\Models\User;
use App\Models\Userconfig;
use App\Traits\SenioryearTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;


class EnsemblemembersImport implements OnEachRow, WithHeadingRow
{
    use SenioryearTrait;

    private $clean;
    private $cntr;
    private $dirty;
    private $errors;
    private $ensemble_id;
    private $matches;
    private $school_id;
    private $user_id;

    public function __construct()
    {
        $this->clean = [];
        $this->cntr = 0;
        $this->dirty = [];
        $this->errors = [];
        $this->user_id = $this->getUserId();
        $this->ensemble_id = Userconfig::getValue('ensemble_id', $this->user_id);
        $this->matches = [];
        $this->school_id = Userconfig::getValue('school_id', $this->user_id);
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    /**
     * @param Row $row
     * @return Ensemblemember
     *
     * ex:
     * array:6 [▼
     *    "first" => "Mariana"
     *    "last" => "Banegas"
     *    "middle" => null
     *    "ensemble" => "Ridge Chorale"
     *    "voicepart" => "si"
     *    "grade" => 9
     * ]
     */
    public function onRow(Row $row)
    {
        $this->cntr++;

        $this->dirty = [
            'first'=> $row['first'],
            'last' => $row['last'],
            'middle' => $row['middle'],
            'ensemble' => $row['ensemble'],
            'voicepart' => $row['voicepart'],
            'grade' => $row['grade'],
        ];
echo '<br /><b><u>'.strtoupper($this->dirty['first'].' '.$this->dirty['last']).'</u></b><br />';
        $this->cleanInputs();

        $this->findCurrentUser();

        if(count($this->matches)){
            dd($this->matches);
        }

        if(count($this->errors)){
            dd($this->errors);
        }

        echo $this->clean['first'].' '.$this->clean['last'].' has no matches, no errors<br />';

        $this->clean = [];
       /* dd($this->clean);
        return new Ensemblemember([
            'ensemble_id' => Userconfig::getValue('ensemble_id', auth()->id()),
            'schoolyear_id' => Userconfig::getValue('schoolyear_id', auth()->id()),
            'user_id' => 0,
            'teacher_user_id' => auth()->id(),
            'instrumentation_id' => 0,
        ]);*/
    }
/** END OF PUBLIC FUNCTIONS **************************************************/

    private function getUserId()
    {
        return auth()->id();
    }

    private function cleanInputs()
    {
        //FIRST NAME
        if(strlen($this->dirty['first'])){
            $this->clean['first'] = filter_var($this->dirty['first'], FILTER_SANITIZE_STRING);
        }else{
            $this->errors[$this->cntr]['first'] = 'First name is required.';
        }

        //LAST NAME
        if(strlen($this->dirty['last'])){
            $this->clean['last'] = filter_var($this->dirty['last'], FILTER_SANITIZE_STRING);
        }else{
            $this->errors[$this->cntr]['last'] = 'Last name is required.';
        }

        //MIDDLENAME
        if(strlen($this->dirty['middle'])){
            $this->clean['middle'] = filter_var($this->dirty['middle'], FILTER_SANITIZE_STRING);
        }else{
            $this->clean['middle'] = NULL;
        }

        //ENSEMBLE
        $this->clean['ensemble'] = Ensemble::where('name', 'LIKE', $this->dirty['ensemble'])
            ->where('school_id', $this->school_id)
            ->first();
        if(is_null($this->clean['ensemble'])){
            $this->errors[$this->cntr]['ensemble'] = 'No ensemble found with the name: '.$this->dirty['ensemble'].'.';
        }

        //INSTRUMENTATION
        $instrumentation = Instrumentation::where('descr', 'LIKE', $this->dirty['voicepart'])->first();
        if(! $instrumentation){
            $instrumentation = Instrumentation::where('abbr', 'LIKE', $this->dirty['voicepart'])->first();
        }
        if($instrumentation){
            $this->clean['instrumentation'] = $instrumentation;
        }else{
            $this->errors[$this->cntr]['instrumentation'] = 'No voice part found as: '.$this->dirty['voicepart'];
        }

        //CLASSOF
        if(! is_numeric($this->dirty['grade'])){
            $this->errors[$this->cntr]['grade'] = 'Grade must be a whole number.';
        }else{
            if($this->dirty['grade'] < 13){
                $this->clean['classof'] = $this->classOf($this->dirty['grade']);
            }else{
                $this->clean['classof'] = (int)$this->dirty['grade'];
            }
        }

    }

    private function findCurrentUser()
    {
        $matches = collect();
        $users = User::where('username', 'LIKE', '%'.substr($this->clean['first'], 0, 1).$this->clean['last'].'%')->get();
echo '<br />'.serialize($users).'<br />';
        if($users->count()){
            $firstcut = Person::where('first', 'LIKE', $this->clean['first'])->where('last', 'LIKE', $this->clean['last'])->get();

            $matches = $users->filter(function($user) use ($firstcut){
               return $firstcut->contains($user->person);
            });
        }

        if($matches->count()) {
            foreach ($matches as $user) {
                if ($user->isStudent() &&
                    (! is_null($user->person->student->schools)) &&
                    $user->person->student->schools->contains($this->school_id) &&
                    $user->person->student->classof == $this->clean['classof']) {

                    $this->matches[$this->cntr] = 'The entry at row: ' . $this->cntr . ' appears to be currently in the system.  Please update this student\'s record manually.';
                    return true;
                }
            }
        }

        return false;

    }

}
