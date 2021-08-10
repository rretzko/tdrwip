<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Registrant
     * @return Response
     */
    public function show(Registrant $registrant)
    {
        return view('registrants.registrant.show', [
            'eventversion' => Eventversion::find($registrant->eventversion_id),
            'registrant' => $registrant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Registrant $registrant
     * @return Response
     */
    public function update(Request $request, Registrant $registrant)
    {
        $data = $request->validate([
            'programname' => ['string','required'],
            'instrumentations' => ['array','required'],
            'instrumentations.*' => ['numeric'],
            'instrumentations.0' => ['required'],
        ]);

        $registrant->programname = $data['programname'];

        $registrant->save();

        $registrant->instrumentations()->sync($data['instrumentations']);

        $registrant->refresh();

        return view('registrants.registrant.show', [
            'eventversion' => Eventversion::find($registrant->eventversion_id),
            'registrant' => $registrant,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
