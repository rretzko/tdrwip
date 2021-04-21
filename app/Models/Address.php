<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Encryptable,HasFactory;

    protected $encryptable = ['address01','address02','city','postalcode'];

    protected $fillable = ['user_id', 'address01','address02','city','geostate_id','postalcode'];

    protected $primaryKey = 'user_id';

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
