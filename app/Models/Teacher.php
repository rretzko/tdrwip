<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];
    protected $primaryKey = 'user_id';

    public function hasGradetype(School $school, $gradetype_id) : bool
    {
        return DB::table('gradetype_school_user')
            ->where('gradetype_id', '=', $gradetype_id)
            ->where('school_id', '=', $school->id)
            ->where('user_id', '=', auth()->id())
            ->value('id') ?? 0;
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id', 'user_id');
    }

    /**
     * Return the School object for the currently selected school
     */
    public function school()
    {
        return School::find(Userconfig::getValue('school_id', auth()->id()));
    }

    public function saveGradetype(School $school, $gradetype_id, bool $value)
    {
        ($value)
            ? $this->GradetypeAdd($school, $gradetype_id)
            : $this->GradetypeRemove($school, $gradetype_id);
    }

    public function students()
    {
        $a = [];
        $user_ids = DB::table('student_teacher')
            ->where('teacher_user_id', '=', auth()->id())
            ->get('student_user_id');
        $school = $this->school();

        foreach($user_ids AS $stdclass){
            $s = Student::find($stdclass->student_user_id);
            $s->student_user_id = $stdclass->student_user_id;
            $s->teacher_user_id = auth()->id();
            $s->school_id = $school->id;

            $a[] = $s;
        }

        return collect($a);
    }

    public function tenureYearsAtSchool($school_id)
    {
        $years = 0;

        foreach($this->person->user->tenures->where('school_id', $school_id) AS $tenure){

            $years += ((($tenure->endyear) ?: date('Y')) - $tenure->startyear);
        }

        return $years;
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function GradetypeAdd(School $school, int $gradetype_id)
    {
        if(! $this->hasGradetype($school, $gradetype_id)){

            DB::table('gradetype_school_user')
                ->insert([
                    'gradetype_id' => $gradetype_id,
                    'school_id' => $school->id,
                    'user_id' => auth()->id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
    }

    private function GradetypeRemove(School $school, int $gradetype_id)
    {
        if($this->hasGradetype($school, $gradetype_id)){

            DB::table('gradetype_school_user')
                ->where('gradetype_id', '=', $gradetype_id)
                ->where('school_id', '=', $school->id)
                ->where('user_id', '=', auth()->id())
                ->delete();
        }
    }
}
