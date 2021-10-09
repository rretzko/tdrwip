<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use Illuminate\Http\Request;

class RegistrantAdjudicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Eventversion $eventversion)
    {
        $adjudicator = \App\Models\Adjudicator::with('user','user.person')
            ->where('user_id', auth()->id())
            ->where('eventversion_id', $eventversion->id)
            ->first();

        return view('registrants.adjudication.index', [
            'eventversion' => $eventversion,
            'room' => \App\Models\Room::with('adjudicators')->where('id', $adjudicator->room_id)->first(),
            'registrants' => $adjudicator->registrants,
            'auditioner' => null,
            'scoringcomponents' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id //registrant->id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auditioner = \App\Models\Registrant::find($id);
        $eventversion = Eventversion::find(\App\Models\Userconfig::getValue('eventversion', auth()->id()));

        $adjudicator = \App\Models\Adjudicator::with('user','user.person')
            ->where('user_id', auth()->id())
            ->where('eventversion_id', $eventversion->id)
            ->first();

        $scoringcomponents = \App\Models\Scoringcomponent::where('eventversion_id', $eventversion->id)->get();

        return view('registrants.adjudication.index', [
            'eventversion' => $eventversion,
            'room' => \App\Models\Room::with('adjudicators')->where('id', $adjudicator->room_id)->first(),
            'registrants' => $adjudicator->registrants,
            'auditioner' => $auditioner,
            'scoringcomponents' => $scoringcomponents,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->validate([
           'components' => ['required', 'array'],
           'components.*' => ['required', 'numeric'],
        ]);

        $eventversion = Eventversion::find(\App\Models\Userconfig::getValue('eventversion', auth()->id()));

        foreach($inputs['components'] AS $component_id => $score) {

            \App\Models\Score::updateOrCreate(
                [
                    'eventversion_id' => $eventversion->id,
                    'filecontenttype_id' => $component_id,
                    'registrant_id' => $id,
                    'user_id' => auth()->id(),
                ],
                [
                    'proxy_id' => auth()->id(),
                    'score' => $score,
                ]
            );
        }

        return $this->index($eventversion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
