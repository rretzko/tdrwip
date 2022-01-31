<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Userconfig;
use Illuminate\Http\Request;

class MediauploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \App\Models\Registrant $registrant
     * @param  \App\Models\Filecontenttype $filecontenttype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Models\Registrant $registrant, \App\Models\Filecontenttype $filecontenttype)
    {
        if($request->hasFile($filecontenttype->descr)) {

            if($request->{$filecontenttype->descr}->guessExtension() === 'mp3'){

                //using symbolic links
                /*
                $directory = 'public/'
                    . Userconfig::getValue('event', auth()->id()).'/'
                    . Userconfig::getValue('eventversion', auth()->id()).'/'
                    . $registrant->instrumentations->first()->id.'/'
                    . $filecontenttype->id;
                */

                //using direct access under /public/assets directory
                $directory = 'public/assets/mp3s/'
                    . Userconfig::getValue('event', auth()->id()).'/'
                    . Userconfig::getValue('eventversion', auth()->id()).'/'
                    . $registrant->instrumentations->first()->id.'/'
                    . $filecontenttype->id;

                $path = $request->{$filecontenttype->descr}->store($directory);

                \App\Models\Fileupload::updateOrCreate(
                    [
                        'registrant_id' => $registrant->id,
                        'filecontenttype_id' => $filecontenttype->id,
                    ],
                    [
                        'server_id' => 'none',
                        'folder_id' => substr($path,7), //remove 'public/'
                        'uploaded_by' => auth()->id(),
                    ]
                );
            }

            return back();
        }

        echo 'honk';
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
