<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ensemble extends Model
{
    use HasFactory;

    protected $fillable = ['abbr', 'descr', 'ensembletype_id', 'name', 'school_id', 'startyear', 'user_id',];

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
        };

        return $a;
    }

    public function gradetypes()
    {
        return $this->belongsToMany(Gradetype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
