<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['expiration', 'grade_levels', 'membershiptype_id', 'organization_id', 'subjects', 'user_id',];

    protected $with = ['person','roletypes'];

    public function expirationMdy()
    {
        return Carbon::parse($this->expiration)->format('M d, Y');
    }

    public function expired(): bool
    {
        //early exit if $this->expiration === blank || null
        if(! $this->expiration){ return false;}

        return $this->expiration < Carbon::now();
    }

    public function membershiptype()
    {
        return $this->belongsTo(Membershiptype::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'user_id', 'id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class,'user_id', 'user_id');
    }

    public function roletypes()
    {
        return $this->belongsToMany(Roletype::class);
    }


}
