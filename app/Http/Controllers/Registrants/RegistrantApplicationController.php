<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Eapplication;
use App\Models\Eventversion;
use App\Models\Registrant;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Userconfig;
use Barryvdh\DomPDF\Facade\Pdf;
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

            return view($this->pathEapplication($registrant), //ex. applications/25/73/eapplication
                [
                    'eventversion' => $registrant->eventversion,
                    'page_title' => 'PAGE TITLE',
                    'path_update' => 'PATH UPDATE',
                    'registrant' => $registrant,
                    'me' => auth()->user()->person,
                    'eapplication' => $registrant->eapplication,
                    'school' => School::find(Userconfig::getValue('school', auth()->id())),
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
        $school = School::find(Userconfig::getValue('school', auth()->id())); //$registrant->student->person->user->schools->first();

        $eventversion = $registrant->eventversion;
        $filename = self::build_Filename($eventversion, $registrant); //ex: "2021_NJASC_2021_BhargavaV.pdf"
        $me = auth()->user();

        $registrantfullname = $registrant->student->person->fullName;
        $registrantfirstname = $registrant->student->person->first;
        $schoolname = $registrant->student->currentSchool->shortName;

        $eapplication = Eapplication::find($registrant->id) ?: null;

        //ex. pages.pdfs.applications.12.64.application
        $pdf = Pdf::loadView('pdfs.applications.'//9.65.2021_22_application',
            . $eventversion->event->id
            .'.'
            . $eventversion->id
            . '.application',
            //.applicationTest',
            compact('registrant','eventversion', 'teacher', 'school','me',
            'registrantfullname','registrantfirstname','schoolname','eapplication'));

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
            'school' => School::find(Userconfig::getValue('school',auth()->id())),
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
            'absences' => ['nullable', 'boolean'],
            'courtesy' => ['nullable', 'boolean'],
            'dressrehearsal' => ['nullable', 'boolean'],
            'eligibility' => ['nullable', 'boolean'],
            'imageuse' => ['nullable', 'boolean'],
            'lates' => ['nullable', 'boolean'],
            'parentread' => ['nullable', 'boolean'],
            'rulesandregs' => ['nullable', 'boolean'],
            'signatureguardian' => ['nullable', 'boolean'],
            'signaturestudent' => ['nullable', 'boolean'],
            'videouse' => ['nullable', 'boolean'],
            'paymentmethod' => ['nullable','string'],
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
                'absences' => ($data['absences'] ?? 0),
                'courtesy' => ($data['courtesy'] ?? 0),
                'dressrehearsal' => ($data['dressrehearsal'] ?? 0),
                'eligibility' => ($data['eligibility'] ?? 0),
                'imageuse' => ($data['imageuse'] ?? 0),
                'lates' => ($data['lates'] ?? 0),
                'parentread' => ($data['parentread'] ?? 0),
                'rulesandregs' => ($data['rulesandregs'] ?? 0),
                'signatureguardian' => ($data['signatureguardian'] ?? 0),
                'signaturestudent' => ($data['signaturestudent'] ?? 0),
                'videouse' => ($data['videouse'] ?? 0),
                'paymentmethod' => ($data['paymentmethod'] ?? 'none'),
            ],
        );

        //update registrant status
        /** @todo Candidate for a separate model for default definitions of Registant status
         *  plus methods to deal with customized definitions
         */
        //SJCDA eApplication is considered registered if both esignatures are made.
        if (
            (($registrant->eventversion->event->id === 11) ||
                ($registrant->eventversion->event->id === 12)) &&
                (array_key_exists('signatureguardian', $data) &&
                    array_key_exists('signaturestudent', $data))) {

            $registrant->resetRegistrantType('registered');

        }elseif($registrant->eventversion->event->id === 19) {

            $registrant->resetRegistrantType($this->allshoreRules($data, $registrant));

        }else {

            $registrant->resetRegistrantType('applied');
        }

        return view('registrants.index',['exception' => false]);
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

    public function walkIn(Registrant $registrant)
    {
        //$registrant->auditiondetail->applied();
        $teacher = Teacher::find(auth()->id());
        $eventversion = $registrant->eventversion;

        //early exit
        if($eventversion->eventversionconfigs->onsiteregistrationfee === '0.00'){
            return back()->with('status', 'This event does not have on-site registration.');
        }

        $school = School::find(Userconfig::getValue('school', auth()->id())); //$registrant->student->person->user->schools->first();

        $filename = self::build_Filename($eventversion, $registrant); //ex: "2021_NJASC_2021_BhargavaV.pdf"
        $me = auth()->user();

        $registrantfullname = $registrant->student->person->fullName;
        $registrantfirstname = $registrant->student->person->first;
        $schoolname = $registrant->student->currentSchool->shortName;

        $eapplication = Eapplication::find($registrant->id) ?: null;

        //ex. pages.pdfs.applications.12.64.application
        $pdf = Pdf::loadView('pdfs.applications.'//9.65.2021_22_application',
            . $eventversion->event->id
            .'.'
            . $eventversion->id
            . '.walk_ins.application',
            //.applicationTest',
            compact('registrant','eventversion', 'teacher', 'school','me',
                'registrantfullname','registrantfirstname','schoolname','eapplication'));

        //log application printing
        Application::create([
            'registrant_id' => $registrant->id,
            'updated_by' => auth()->id(),
        ]);

        //update registrant status
        $registrant->resetRegistrantType('applied');

        return $pdf->download($filename);
    }

    private function allshoreRules(array $data, Registrant $registrant)
    {
        $virtualaudition = Eventversion::find($registrant->eventversion_id)->eventversionconfigs->virtualaudition;
        $status = 'eligible';

        $tests = ['absences', 'eligibility','imageuse', 'lates', 'rulesandregs', 'signatureguardian', 'signaturestudent'];

        foreach($tests AS $test){

            if(! (array_key_exists($test, $data) && $data[$test] )){

                return $status;
            }
        }

        //passed all tests
        return $virtualaudition ? 'applied' : 'registered' ;
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
