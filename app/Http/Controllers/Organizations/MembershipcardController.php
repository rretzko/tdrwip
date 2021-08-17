<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Membershiptype;
use App\Models\Organization;
use Illuminate\Http\Request;

class MembershipcardController extends Controller
{
    public function create(Request $request)
    {
        dd($request);
    }

    public function show(Organization $organization)
    {
        $membership = Membership::where('user_id', auth()->id())
            ->where('organization_id', $organization->id)
            ->first() ?? new Membership;

        return view('organizations.membershipcard.show',
        [
            'ancestors' => $this->buildAncestors($organization->ancestors()),
            'membership' => $membership,
            'membershiptypes' => Membershiptype::all(),
            'organization' => $organization,
        ]);
    }

    public function update(Request $request)
    {
        dd($request);
    }

    private function buildAncestors($ancestors)
    {
        //early exit
        if(! count($ancestors)){ return '';}

        $str = '<ul class="list-disc ml-8">';

        foreach($ancestors AS $ancestor){

            $str .= '<li>'.$ancestor->name.'</li>';
        }

        $str .= '</ul>';

        return $str;
    }
}
