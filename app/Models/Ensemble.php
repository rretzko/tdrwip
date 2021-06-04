<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ensemble extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['abbr', 'descr', 'ensembletype_id', 'name', 'school_id', 'startyear', 'user_id',];

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

    public function members()
    {
        $ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
        $schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());

        $members = Ensemblemember::with('person')
            ->where('ensemble_id', $ensemble_id)
            ->where('schoolyear_id', $schoolyear_id)
            ->get();

        return $members;
    }

    public function nonmembers()
    {
        return Student::with('person')
            ->whereHas('teachers', function($query){
                return $query->where('user_id', '=', auth()->id());
            })
            ->get()
            ->sortBy('person.last');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
