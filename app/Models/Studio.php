<?php

namespace App\Models;

use App\Traits\MailingAddressTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory,MailingAddressTrait;

    protected $fillable = ['user_id', 'name','address01', 'address02', 'city', 'geostate_id', 'postalcode'];

    public function getMailingAddressAttribute()
    {
        return $this->mailingAddress($this);
    }

    public function getYearsAttribute()
    {
        $years = 0;

        foreach($this->studiodetails AS $detail){

            $years += ($detail->closed - $detail->opened);
        }

        return $years;
    }

    public function Studiodetails()
    {
        return $this->hasMany(Studiodetail::class);
    }

    public function Studiogrades()
    {
        return $this->hasMany(Studiograde::class);
    }

}
