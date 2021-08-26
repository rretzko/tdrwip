<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Eapplication;
use App\Models\Eventversion;
use App\Models\Registrant;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade AS PDF;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistrantApplicationController extends Controller
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
     * @param Registrant
     * @return Response
     */
    public function create(Registrant $registrant)
    {
        if($registrant->eventversion->eventversionconfigs->eapplication){ //eventversion is using Eapplications

            return view($this->pathEapplication($registrant), [
                'eventversion' => $registrant->eventversion,
                'page_title' => 'PAGE TITLE',
                'path_update' => 'PATH UPDATE',
                'registrant' => $registrant,
                'me' => auth()->user()->person,
                'eapplication' => $registrant->eapplication,
            ]);
        }

        return view($this->pathApplication($registrant), [
            'eventversion' => $registrant->eventversion,
            'page_title' => 'PAGE TITLE',
            'path_update' => 'PATH UPDATE',
            'registrant' => $registrant,
            'me' => auth()->user()->person,
        ]);
    }

    /**
     * PDF download of application
     *
     * @param  Registrant
     * @return Response
     */
    public function download(Registrant $registrant)
    {
        //$registrant->auditiondetail->applied();
        $teacher = Teacher::find(auth()->id());
        $school = $registrant->student->person->user->schools->first();

        $eventversion = $registrant->eventversion;
        $filename = self::build_Filename($eventversion, $registrant); //ex: "2021_NJASC_2021_BhargavaV.pdf"
        $me = auth()->user();

        //ex. pages.pdfs.applications.12.64.application
        $pdf = PDF::loadView('pdfs.applications.'//9.65.2021_22_application',
            . $eventversion->event->id
            .'.'
            . $eventversion->id
            . '.application',
            //.applicationTest',
            compact('registrant','eventversion', 'teacher', 'school','me'));

        //log application printing
        Application::create([
            'registrant_id' => $registrant->id,
            'updated_by' => auth()->id(),
        ]);

        //update registrant status
        $registrant->resetRegistrantType('applied');

        return $pdf->download($filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  Registrant
     * @return Response
     */
    public function show(Registrant $registrant)
    {
        return view($this->pathEapplication($registrant), [
            'eventversion' => $registrant->eventversion,
            'page_title' => 'PAGE TITLE',
            'path_update' => 'PATH UPDATE',
            'registrant' => $registrant,
            'me' => auth()->user()->person,
            'eapplication' => $registrant->eapplication,
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
     * @param  App\Models\Registrant $registrant
     * @return Response
     */
    public function update(Request $request, Registrant $registrant)
    {
        $data = $request->validate([
            'signatureguardian' => ['nullable', 'numeric'],
            'signaturestudent' => ['nullable', 'numeric'],
        ]);

        Application::create([
            'registrant_id' => $registrant->id,
            'updated_by' => auth()->id(),
        ]);

        Eapplication::updateOrCreate(
            [
                'registrant_id' => $registrant->id,
                'eventversion_id' => $registrant->eventversion->id,
            ],
            [
                'signatureguardian' => ($data['signatureguardian'] ?? 0),
                'signaturestudent' => ($data['signaturestudent'] ?? 0),
            ],
        );

        //update registrant status
        $registrant->resetRegistrantType('applied');

        return view('registrants.index');
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
    * @since 2020.08.08
    *
    * @param Eventversion $eventversion
    * @param Registrant $registrant
    * @return string ex: SJCDA_Sr_High_2021_RetzkoF.pdf
    */
    private function build_Filename(Eventversion $eventversion,
                                    Registrant $registrant) : string
    {
        return str_replace(' ', '_', //'2022_NJASC_2022_BhargavaV(2022).pdf';
                str_replace('.', '', $eventversion->short_name))
            . '_'
            . $eventversion->senior_class_of
            . '_'
            . $registrant->student->person->last
            . substr($registrant->student->person->first, 0, 1)
            . '.pdf';
    }

    private function pathApplication(Registrant $registrant)
    {
        return 'applications/'
            .$registrant->eventversion->event->id
            .'/'
            .$registrant->eventversion->id
            .'/application';
    }

    private function pathEapplication(Registrant $registrant)
    {
        return 'applications/'
            .$registrant->eventversion->event->id
            .'/'
            .$registrant->eventversion->id
            .'/eapplication';
    }
}
