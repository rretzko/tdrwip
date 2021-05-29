<?php

namespace App\Http\Controllers;

use App\Models\Ensemble;
use App\Models\Userconfig;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsembleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ensembles = Ensemble::all();

        return view('/ensembles', compact('ensembles'));

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
        $attributes = $request->validate([
            'abbr' => 'required',
            'name' => 'required',
            'descr' => 'nullable',
        ]);

        $attributes['school_id'] = Userconfig::getValue('school_id');

        //Ensemble::create($attributes);
        auth()->user()->ensembles()->create($attributes);

        return redirect('ensembles');

    }

    /**
     * Display the specified resource.
     *
     * @param int $ensemble_id
     * @return Response
     */
    public function show($ensemble_id)
    {
        $ensemble = Ensemble::findOrFail($ensemble_id);
        return view('ensembles.show', compact('ensemble'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ensemble $ensemble
     * @return Response
     */
    public function edit(Ensemble $ensemble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ensemble $ensemble
     * @return Response
     */
    public function update(Request $request, Ensemble $ensemble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ensemble $ensemble
     * @return Response
     */
    public function destroy(Ensemble $ensemble)
    {
        //
    }
}
