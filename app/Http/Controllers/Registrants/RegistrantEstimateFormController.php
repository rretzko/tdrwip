<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Estimateform;
use App\Models\Eventversion;
use App\Models\Registrant;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Userconfig;
use App\Models\Utility\Registrants;
use App\Models\Utility\RegistrantsByInstrumentation;
use Barryvdh\DomPDF\Facade AS PDF;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistrantEstimateFormController extends Controller
{
    /**
     * PDF download of application
     *
     * @todo Test screen display and printing of membership card
     *
     * @param  Registrant
     * @return Response
     */
    public function download(Eventversion $eventversion)
    {
        $teacher = Teacher::find(auth()->id());
        $school = School::find(Userconfig::getValue('school',auth()->id()));

        $filename = self::build_Filename($eventversion, $school); //ex: "2021_NJASC_2021_Cinnaminson.pdf"
        $me = auth()->user();

        $registrants = Registrants::registered();
        $rbi = new RegistrantsByInstrumentation;
        $registrantsbyinstrumentation = $rbi->getArray();

        //ex. pages.pdfs.applications.12.64.application
        $pdf = PDF::loadView('pdfs.estimateforms.'//9.65.2021_22_application',
            . $eventversion->event->id
            .'.'
            . $eventversion->id
            . '.estimateform',
            //.applicationTest',
            compact('eventversion', 'teacher', 'school', 'me', 'registrants', 'registrantsbyinstrumentation'));

        //log application printing
        Estimateform::create([
            'user_id' => auth()->id(),
        ]);

        return $pdf->download($filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  Registrant
     * @return Response
     */
    public function show(Eventversion $eventversion)
    {
        $registrantsbyinstrumentation = new RegistrantsByInstrumentation;

        return view('registrants.estimateforms.'.$eventversion->event->id.'.'.$eventversion->id.'.show',
        [
            'eventversion' => $eventversion,
            'registrants' => Registrants::registered(),
            'registrantsbyinstrumentation' => $registrantsbyinstrumentation->getArray(),
        ]);
    }


    /**
     * @since 2021.08.16
     *
     * @param Eventversion $eventversion
     * @param School $school
     * @return string ex: SJCDA_Sr_High_2021_Cinnaminson.pdf
     */
    private function build_Filename(Eventversion $eventversion, School $school) : string
    {
        return str_replace(' ', '_', //'2022_NJASC_2022_BhargavaV(2022).pdf';
                str_replace('.', '', $eventversion->short_name))
            . '_'
            . $eventversion->senior_class_of
            . '_'
            . substr($school->shortName, 0, 10)
            . '.pdf';
    }

    private function pathApplication(Registrant $registrant)
    {
        return $path='applications/'
            .$registrant->eventversion->event->id
            .'/'
            .$registrant->eventversion->id
            .'/application';
    }
}
