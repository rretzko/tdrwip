<?php

namespace App\Models;

use App\Models\Membership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    use HasFactory;

    protected $with = ['memberships',];

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

    /**
     * Returns flat, semi-ordered Collection of Organizations from $this->id through lowest branch of tree
     *
     * @return Collection
     */
    public function decendentsTree()
    {
        $orgs = collect();

        foreach(Organization::where('parent_id', $this->id)->get() AS $child){
            if($child->hasChildren){
                foreach(Organization::where('parent_id', $child->id)->get() AS $grandchild){
                    if($grandchild->hasChildren){
                        foreach(Organization::where('parent_id', $grandchild->id)->get() AS $greatgrandchild){
                            if($greatgrandchild->hasChildren){
                                foreach(Organization::where('parent_id', $greatgrandchild->id)->get() AS $great2grandchild){
                                    $orgs->prepend($great2grandchild);
                                }
                            }
                            $orgs->prepend($greatgrandchild);
                        }
                    }
                    $orgs->prepend($grandchild);
                }
            }

            $orgs->prepend($child);
        }

        $orgs->prepend($this);

        return $orgs;
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

    public function getHasMembershipmanagersAttribute()
    {
        return DB::table('memberships')
            ->join('membership_roletype', 'memberships.id','=','membership_roletype.membership_id')
            ->join('roletypes','membership_roletype.roletype_id','=','roletypes.id')
            ->where('memberships.organization_id','=',$this->id)
            ->where('roletypes.descr','=','membership manager')
            ->select('roletypes.descr')
            ->count();
    }

    public function isMember($user_id)
    {
        return $this['memberships']->contains($user_id);
    }

    public function membership($user_id)
    {
        return Membership::where('user_id', $user_id)
            ->where('organization_id', $this->id)
            ->first();
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function membershipmanagers()
    {
        $role = new Membershipmanager;
        $role->organization_id = $this->id;
        $role->roletype_id = Roletype::where('descr', 'membership manager')->first()->id;
        return Roletype::where('organization_id', $this->id)
            ->get();
    }

    public function users()
    {
        //return $this->belongsToMany(User::class);
    }

}
