<?php

namespace App\Http\Controllers\Auditionresults;

use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Eventversionteacherconfig;
use App\Models\School;
use App\Models\User;
use App\Models\Userconfig;
use Illuminate\Http\Request;

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

        return view('participationfees.index', compact('eventversion','registrants', 'teacher_configs'));
    }
}
