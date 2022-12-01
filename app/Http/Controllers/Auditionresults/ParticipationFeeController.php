<?php

namespace App\Http\Controllers\Auditionresults;

use App\Exports\ParticipationFeeRosterExport;
use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Eventversionteacherconfig;
use App\Models\Payment;
use App\Models\PaymentCategory;
use App\Models\Registrant;
use App\Models\School;
use App\Models\User;
use App\Models\Userconfig;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParticipationFeeController extends Controller
{
    public function index(Eventversion $eventversion)
    {
        $teacher_configs = Eventversionteacherconfig::where('user_id', auth()->id())
            ->where('school_id', Userconfig::getValue('school', auth()->id()))
            ->where('eventversion_id', $eventversion->id)
            ->first();

        $school = School::find(Userconfig::getValue('school', auth()->id()));

        $registrants = $school->acceptedRegistrants($eventversion);

        return view('participationfees.index', compact('eventversion','registrants', 'school', 'teacher_configs'));
    }

    public function update(Request $request)
    {
        $inputs = $request->validate(
            [
                'registrant_id' => ['required', 'numeric', 'exists:registrants,id'],
                'paymenttype_id' => ['required','numeric','exists:paymenttypes,id'],
                'amount' => ['required', 'numeric', 'min:-25','max:25'],
            ]
        );

        $registrant = Registrant::find($inputs['registrant_id']);

        Payment::create([
            'user_id' => $registrant->user_id,
            'registrant_id' => $inputs['registrant_id'],
            'eventversion_id' => $registrant->eventversion->id,
            'paymentcategory_id' => PaymentCategory::PARTICIPATION,
            'paymenttype_id' => $inputs['paymenttype_id'],
            'school_id' => $registrant->school_id,
            'vendor_id' => 'cash or check payment',
            'amount' => $inputs['amount'],
            'updated_by' => auth()->id(),
        ]);

        $mssg = 'Successful update of $'.$inputs['amount'].' for '.$registrant->programname.'!';

        return redirect()->route('participationfees.index', ['eventversion' => $registrant->eventversion->id])
            ->with('success', $mssg);
    }

    public function export()
    {
        $eventversion = Eventversion::find(Userconfig::getValue('eventversion', auth()->id()));

        $school = School::find(Userconfig::getValue('school', auth()->id()));

        $registrants = $school->acceptedRegistrants($eventversion);

        $filename = 'participationFees_'.date('Ymd').'_'.date('Gis').'.csv';

        return Excel::download(new ParticipationFeeRosterExport($registrants), $filename);
    }

    /**
     * Switch teacher decision to allow or deny functionality for student use of PayPal for participation fees
     * @return void
     */
    public function teacherToggle()
    {
        $eventversion = Eventversion::find(Userconfig::getValue('eventversion', auth()->id()));

        $teacher_configs = Eventversionteacherconfig::where('user_id', auth()->id())
            ->where('eventversion_id', $eventversion->id)
            ->where('school_id', Userconfig::getValue('school', auth()->id()))
            ->first();

        $teacher_configs->update(
            [
                'paypal_participation_fee' => (! $teacher_configs->paypal_participation_fee),
            ]
        );

        return redirect()->route('participationfees.index', ['eventversion' => $eventversion]);
    }
}
