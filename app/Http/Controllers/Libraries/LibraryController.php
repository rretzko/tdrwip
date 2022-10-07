<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questionnaire = \App\Models\Qlibrary::firstOrCreate(
            [
                'user_id' => auth()->id(),
            ]
        );

        $view = $questionnaire->saved ? 'libraries.index' : 'libraries.questionnaire';

        return view($view, compact('questionnaire'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return __FUNCTION__;
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
     * @param Library $library
     * @return Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Library $library
     * @return Response
     */
    public function edit(Library $library)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Library $library
     * @return Response
     */
    public function update(Request $request, Library $library)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Library $library
     * @return Response
     */
    public function destroy(Library $library)
    {
        //
    }

    public function questionnaire(Request $request)
    {
        $inputs = $request->validate(
           [
                "title" => ['nullable','numeric','min:0','max:1'],
                "subtitle" => ['nullable','numeric','min:0','max:1'],
                "composer"  => ['nullable','numeric','min:0','max:1'],
                "arranger"  => ['nullable','numeric','min:0','max:1'],
                "publisher" => ['nullable','numeric','min:0','max:1'],
                "arrangement" => ['nullable','numeric','min:0','max:1'],
                "accompaniment" => ['nullable','numeric','min:0','max:1'],
                "language"  => ['nullable','numeric','min:0','max:1'],
                "tempo" => ['nullable','numeric','min:0','max:1'],
                "year" => ['nullable','numeric','min:0','max:1'],
                "ensemble" => ['nullable','numeric','min:0','max:1'],
                "concert" => ['nullable','numeric','min:0','max:1'],
                "difficulty" => ['nullable','numeric','min:0','max:1'],
                "comments" => ['nullable','numeric','min:0','max:1'],
                "must_haves" => ['nullable','string'],
                "nice_haves" => ['nullable','string'],
                "fee" => ['required'],
            ]
        );

        $q = \App\Models\Qlibrary::updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            [
                "title" => array_key_exists('title',$inputs) ? $inputs['title'] : 0,
                "subtitle" => array_key_exists('subtitle',$inputs) ? $inputs['subtitle'] : 0,
                "composer"  => array_key_exists('composer',$inputs) ? $inputs['composer'] : 0,
                "arranger"  => array_key_exists('arranger',$inputs) ? $inputs['arranger'] : 0,
                "publisher" => array_key_exists('publisher',$inputs) ? $inputs['publisher'] : 0,
                "arrangement" => array_key_exists('arrangement',$inputs) ? $inputs['arrangement'] : 0,
                "accompaniment" => array_key_exists('accompaniment',$inputs) ? $inputs['accompaniment'] : 0,
                "language"  => array_key_exists('language',$inputs) ? $inputs['language'] : 0,
                "tempo" => array_key_exists('tempo',$inputs) ? $inputs['tempo'] : 0,
                "year" => array_key_exists('year',$inputs) ? $inputs['year'] : 0,
                "ensemble" => array_key_exists('ensemble',$inputs) ? $inputs['ensemble'] : 0,
                "concert" => array_key_exists('concert',$inputs) ? $inputs['concert'] : 0,
                "difficulty" => array_key_exists('difficulty',$inputs) ? $inputs['difficulty'] : 0,
                "comments" => array_key_exists('comments',$inputs) ? $inputs['comments'] : 0,
                "must_haves" => array_key_exists('must_haves',$inputs) ? $inputs['must_haves'] : 0,
                "nice_haves" => array_key_exists('nice_haves',$inputs) ? $inputs['nice_haves'] : 0,
                "fee" => array_key_exists('fee',$inputs) ? $inputs['fee'] : 0,
            ]
        );

        session()->flash('success','Thank you!  Your questionnaire has been saved.');

Mail::send(['html' => 'mails.qlibrary'], $inputs, function($message){
   $message->to('rick@mfrholdings.com')
   ->subject('New Library Questionnaire Response')
   ->from('rick@mfrholdings.com','Rick Retzko');
});

        return back();
    }
}
