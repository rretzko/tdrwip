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

    public function saveGradetype(School $school, $gradetype_id, bool $value)
    {
        ($value)
            ? $this->GradetypeAdd($school, $gradetype_id)
            : $this->GradetypeRemove($school, $gradetype_id);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class,'user_id', 'user_id');
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
