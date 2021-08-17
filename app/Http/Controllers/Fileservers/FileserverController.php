<?php

namespace App\Http\Controllers\Fileservers;

use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Filecontenttype;
use App\Models\Fileserver;
use App\Models\Fileupload;
use App\Models\Fileuploadfolder;
use App\Models\Person;
use App\Models\Registrant;
use App\Models\Userconfig;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileserverController extends Controller
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
    public function store(Request $request, Registrant $registrant,
                          Filecontenttype $filecontenttype, Person $person,
                            $folder_id)
    {
        //fileserver/confirmation/651347/5/351/3595dabd1a1aedb8?successful=true&video_id=069dd9b01c1ee0c28f
        //fileserver/confirmation/$this->registrant->id.'/'.$filecontenttype->id.'/'.auth()->id().'/'.$folder_Id
        Fileupload::updateOrCreate([
           'registrant_id' => $registrant->id,
           'filecontenttype_id' => $filecontenttype->id,
           'server_id' => $request['video_id'],
           'folder_id' => $folder_id,
           'uploaded_by' => $person->user_id,
        ]);

        $eventversion = Eventversion::find(Userconfig::getValue('eventversion',auth()->id()));
        $fileserver = new Fileserver($registrant);

        $folders = Fileuploadfolder::where('eventversion_id', $eventversion->id)
            ->whereIn('instrumentation_id', $registrant->instrumentations)
            ->get();

        return view('registrants.registrant.show', [
        'eventversion' => Eventversion::find($registrant->eventversion_id),
        'filename' => $fileserver->buildFilename($registrant),
        'fileserver' => $fileserver,
        'folders' => $folders,
        'registrant' => $registrant,
    ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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