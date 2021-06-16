<?php

namespace App\Models;

use App\Traits\MailingAddressTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    use HasFactory,MailingAddressTrait,SoftDeletes;

    protected $fillable = ['name', 'address01', 'address02', 'city', 'geostate_id', 'postalcode'];

    public function getCurrentUserGradesAttribute()
    {
        $grades = DB::table('gradetype_school_user')
            ->where('school_id', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->pluck('gradetype_id')
            ->toArray();

        return $grades;
    }
    public function getGeostateAbbrAttribute()
    {
        return ($this->geostate_id) ? Geostate::where('id', $this->geostate_id)->first()->abbr : 'ZZ';
    }

    public function getMailingAddressAttribute()
    {
        return $this->mailingAddress($this);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'user_id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
