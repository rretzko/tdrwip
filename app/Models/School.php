<?php

namespace App\Models;

use App\Traits\MailingAddressTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory,MailingAddressTrait;

    protected $fillable = ['name', 'address01', 'address02', 'city', 'geostate_id', 'postalcode'];

    public function getMailingAddressAttribute()
    {
        return $this->mailingAddress($this);
    }
}
