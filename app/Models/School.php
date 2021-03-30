<?php

namespace App\Models;

use App\Traits\MailingAddressTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory,MailingAddressTrait;

    protected $fillable = ['name', 'address01', 'address02', 'city', 'geostate_id', 'postalcode'];

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
