<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['expiration', 'membershiptype_id', 'organization_id', 'user_id'];

    public function expired(): bool
    {
        return $this->expiration < Carbon::now();
    }
}
