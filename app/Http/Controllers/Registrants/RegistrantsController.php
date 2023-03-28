<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Obligation;
use App\Models\Userconfig;
use App\Traits\ExceptionsTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RegistrantsController extends Controller
{
    use ExceptionsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Eventversion $eventversion)
    {
        //set userconfigs
        Userconfig::setValue('eventversion',auth()->id(),$eventversion->id);
        Userconfig::setValue('event',auth()->id(),$eventversion->event->id);
        Userconfig::setValue('organization',auth()->id(),$eventversion->event->organization->id);

        if($eventversion->obligationMet(auth()->id())){

            return $this->show($eventversion);

        }else{

            return view('eventversions.obligations', [
                'eventversion' => $eventversion,
                'exception' => $this->exceptions(),
                ]);
        }
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
     * @param  App\Models\Eventversion $eventversion
     * @return Response
     */
    public function show(Eventversion $eventversion)
    {
        //set userconfigs
        Userconfig::setValue('eventversion', auth()->id(), $eventversion->id);
        Userconfig::setValue('event',auth()->id(),$eventversion['event']->id);
        Userconfig::setValue('organization',auth()->id(),$eventversion['event']['organization']->id);

        $this->updateOrphanedRegistrants($eventversion);

        return view('registrants.index',
            [
                'exception' => $this->exceptions(),
            ]
        );
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

    /**
     * Interrogate database to find all registrants for 2023-24 NJ All-State Chorus
     * where signatures have been confirmed
     * and mp3 files approved
     * and parent information is available
     * but status reflects 'Applied' (registranttype_id=15)
     * Update those registrants to 'Registered' (registrationtype_id=16)
     *
     * @param Eventversion $eventversion
     * @return void
     */
    private function updateOrphanedRegistrants(Eventversion $eventversion)
    {
        if($eventversion->id === 75){

            $res = DB::select(DB::raw("Select a.id,a.programname,a.school_id,i.name,a.user_id
FROM registrants a
JOIN signatures b ON b.registrant_id=a.id
JOIN signatures c ON c.registrant_id=a.id
JOIN signatures d ON d.registrant_id=a.id
JOIN signatures e ON e.registrant_id=a.id
JOIN fileuploads f ON f.registrant_id=a.id
JOIN fileuploads g ON g.registrant_id=a.id
JOIN fileuploads h ON h.registrant_id=a.id
JOIN schools i ON i.id=a.school_id
JOIN guardian_student j ON j.student_user_id=a.user_id
WHERE a.eventversion_id=75
            AND a.registranttype_id=15
            AND b.signaturetype_id=1
            AND b.confirmed IS NOT NULL
            AND c.signaturetype_id=2
            AND c.confirmed IS NOT NULL
            AND d.signaturetype_id=3
            AND d.confirmed IS NOT NULL
            AND e.signaturetype_id=4
            AND e.confirmed IS NOT NULL
            AND f.filecontenttype_id=1
            AND f.approved IS NOT NULL
            AND g.filecontenttype_id=4
            AND g.approved IS NOT NULL
            AND h.filecontenttype_id=5
            AND h.approved IS NOT NULL"));

            foreach($res AS $reg){

                $registrant = \App\Models\Registrant::find($reg->id);

                $registrant->update([
                    'registranttype_id' => \App\Models\Registranttype::REGISTERED,
                ]);
            }
        }
    }
}
