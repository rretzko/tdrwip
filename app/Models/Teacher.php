<?php

namespace App\Models;

use App\Traits\SenioryearTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    use HasFactory, SenioryearTrait;

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

    public function tenures()
    {
        return $this->hasMany(Tenure::class, 'user_id', 'user_id');
    }

    public function saveGradetype(School $school, $gradetype_id, bool $value)
    {
        ($value)
            ? $this->GradetypeAdd($school, $gradetype_id)
            : $this->GradetypeRemove($school, $gradetype_id);
    }

    public function students($search='')
    {
        $a = [];

        //filter students by all, alum or current status
        $filter = Userconfig::getValue('filter_studentroster', $this->user_id);

        //define the current senior year
        $sr_year = $this->senioryear();

        $operator = ($filter === 'alum') ? '<' : '>';
        $value = ($filter === 'all') ? 0 : (($filter === 'alum') ? $sr_year : ($sr_year - 1));//(filter === current)

        //returns array
        $user_ids = DB::table('student_teacher')
            ->join('people','student_teacher.student_user_id', '=','people.user_id')
            ->join('school_user', function($join) {
                $join->on('student_teacher.student_user_id', '=', 'school_user.user_id')
                    ->where('school_user.school_id', '=', Userconfig::getValue('school_id', $this->user_id));
                })
            ->join('students', function($join) use ($operator, $value) {
                $join->on('student_teacher.student_user_id', '=', 'students.user_id')
                    ->where('students.classof', $operator, $value);
            })
            ->where('student_teacher.teacher_user_id', '=', auth()->id())
            ->where('people.last', 'LIKE', '%'.$search.'%')
            //->limit(1)
            ->pluck('student_teacher.student_user_id');

        foreach(Student::with(['person', 'shirtsize',])->findMany($user_ids) AS $s){
            $s->student_user_id = $s->user_id;
            $s->teacher_user_id = auth()->id();
            $s->school_id = $this->school()->id;

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
