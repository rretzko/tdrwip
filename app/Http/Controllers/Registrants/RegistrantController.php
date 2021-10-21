<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Eapplication;
use App\Models\Eventversion;
use App\Models\Fileserver;
use App\Models\Fileuploadfolder;
use App\Models\Registrant;
use App\Models\Userconfig;
use App\Traits\UpdateRegistrantStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class RegistrantController extends Controller
{
    use UpdateRegistrantStatusTrait;

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
        $eventversion = Eventversion::find(Userconfig::getValue('eventversion',auth()->id()));
        $fileserver = new Fileserver($registrant);

        $folders = $this->getFolders($eventversion, $registrant);

        $sjcdaeapplicationshutdown = (Carbon::now() > '2021-10-19 23:59:59');

        return view('registrants.registrant.show', [
            'eventversion' => $eventversion,
            'filename' => $fileserver->buildFilename($registrant),
            'fileserver' => $fileserver,
            'folders' => $folders,
            'registrant' => $registrant,
            'countsignatures' => $this->countSignatures($eventversion, $registrant),
            'sjcdaeapplicationshutdown' => $sjcdaeapplicationshutdown,
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

        $this->updateRegistrantStatus($registrant);

        $sjcdaeapplicationshutdown = (Carbon::now() > '2021-10-19 23:59:59');

        $eventversion = Eventversion::find($registrant->eventversion_id);
        $fileserver = new Fileserver($registrant);
        $folders = $this->getFolders($eventversion, $registrant);

        return view('registrants.registrant.show', [
            'eventversion' => $eventversion,
            'filename' => $fileserver->buildFilename($registrant),
            'fileserver' => $fileserver,
            'folders' => $folders,
            'registrant' => $registrant,
            'countsignatures' => $this->countSignatures($registrant->eventversion, $registrant),
            'sjcdaeapplicationshutdown' => $sjcdaeapplicationshutdown,
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

    private function countSignatures(Eventversion $eventversion, Registrant $registrant)
    {
        //early exit
        if(! $eventversion->eventversionconfigs->eapplication){ return 0;}

        $cntr = 0;

        $eapplication = Eapplication::find($registrant->id);

        $cntr += $eapplication ? $eapplication->signatureguardian : 0;
        $cntr += $eapplication ? $eapplication->signaturestudent : 0;

        return $cntr;
    }

    private function getFolders(Eventversion $eventversion, Registrant $registrant)
    {
        //early exit
        if(! $registrant->instrumentations->count()){ return collect();}

        if($registrant->instrumentations->count() === 1){

            return Fileuploadfolder::where('eventversion_id', $eventversion->id)
                ->where('instrumentation_id', $registrant->instrumentations->first()->id)
                ->get();
        }

        return Fileuploadfolder::where('eventversion_id', $eventversion->id)
            ->whereIn('instrumentation_id', $registrant->instrumentations)
            ->get();

    }
}
