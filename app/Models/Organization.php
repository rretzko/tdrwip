<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    {info(__CLASS__.': '.__METHOD__.': '.__LINE__);
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
        return $this['users']->count();
    }

    public function users()
    {info(__CLASS__.': '.__METHOD__.': '.__LINE__);
        return $this->belongsToMany(User::class);
    }

}
