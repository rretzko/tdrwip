<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    use HasFactory;

    protected $with = ['users'];

    /**
     * Return organizations by:
     *  a) Parent_id === 0, alpha order
     *  b) child organization, alpha order
     *  c) grandchild organiztion, alpha order
     *  d) etc.
     */
    public function parents()
    {
        return Organization::where('parent_id', 0)
            ->orderBy('name')
            ->get();
    }

    public function children()
    {
        return Organization::where('parent_id', $this->id)
            ->orderBy('name')
            ->get();
    }

    public function getAuditionsuiteStatusAttribute() : string
    {
        return Auditionsuitestatus::status($this);
    }

    public function getHasChildrenAttribute() : bool
    {
        return (bool)DB::table('organizations')
            ->where('parent_id', '=', $this->id)
            ->get();
    }

    public function isMember($user_id)
    {
        return $this['users']->contains($user_id);
    }

    public function membership($user_id)
    {
        return Membership::where('user_id', $user_id)
            ->where('organization_id', $this->id)
            ->first();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
