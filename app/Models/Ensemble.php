<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ensemble extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['abbr', 'descr', 'ensembletype_id', 'name', 'school_id', 'startyear', 'user_id',];

    public function assets()
    {
        return $this->belongsToMany(Asset::class)
            ->withTimestamps()
            ->orderBy('descr');
    }

    public function delete()
    {
        DB::table('ensemble_gradetype')
            ->where('ensemble_id', '=', $this->id)
            ->update(['deleted_at' => now()]);

        parent::delete();
    }

    public function ensembletype()
    {
        return $this->belongsTo(Ensembletype::class);
    }

    public function ensemblemembers()
    {
        return $this->hasMany(Ensemblemember::class)
            ->with('instrumentation','person', 'schoolyear')
            ;
    }

    /**
     * @return simple array of gradetype_ids
     */
    public function gradetypeIdsArray()
    {
        $a = [];

        foreach($this->gradetypes AS $gradetype){

            $a[] = $gradetype->id;
        }

        return $a;
    }

    public function gradetypes()
    {
        return $this->belongsToMany(Gradetype::class)
            ->withTimestamps();
    }

    public function instrumentations()
    {
        return Ensembletype::find($this->ensembletype_id)->instrumentations;
    }

    /**
     * Return the count of unique members over the lifetime of the ensemble
     */
    public function lifetimecount()
    {
        return DB::table('ensemblemembers')
            ->where('ensemble_id', '=', $this->id)
            ->distinct()
            ->count('user_id');
    }


    /**
     * Return Ensemblemembers for $schoolyear OR
     * all Ensemblemembers for all years if $schoolyear === null
     *
     * @param Schoolyear|null $schoolyear
     * @return Builder[]|Collection
     */
    public function members(Schoolyear $schoolyear = null)
    {
        $schoolyear_id = ($schoolyear) ? $schoolyear->id : 0;

        $ensemblemembers = $this->ensemblemembers->filter(function($ensemblemember) use ($schoolyear_id) {
            return ($schoolyear_id)
                ? $ensemblemember->schoolyear_id == $schoolyear_id
                : $ensemblemember->schoolyear_id > 0;
        });

        return $ensemblemembers->sortBy('person.last');
    }

    public function nonmembers()
    {
        return Teacher::find(auth()->id())->myStudents()->filter(function($student){

            return (! $student->person->ensembles->contains($this));
        });
    }

    /**
     * Return the count of unique members over the lifetime of the ensemble
     */
    public function schoolyearcount()
    {
        return DB::table('ensemblemembers')
        ->where('ensemble_id', '=', $this->id)
        ->where('schoolyear_id', '=', Userconfig::getValue('schoolyear_id', auth()->id()))
        ->distinct()
        ->count('user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
