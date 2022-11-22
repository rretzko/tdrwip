<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Eventversionteacherconfig;
use App\Models\Userconfig;
use Illuminate\Http\Request;

class PaypalRegistrationFeeController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $fee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $inputs = $request->validate(['fee' => ['required','numeric','min:0','max:1']]);

        $eventversion = Eventversion::find(Userconfig::getValue('eventversion', auth()->id()));
        $eventversionteacherconfig = Eventversionteacherconfig::where('user_id', auth()->id())
            ->where('school_id',Userconfig::getValue('school',auth()->id()))
            ->where('eventversion_id', $eventversion->id)
            ->first();

        $eventversionteacherconfig->update(['paypal_participation_fee' => $inputs['fee']]);

        return redirect()->route('auditionresults.index',
        [
            'eventversion' => $eventversion,
            'eventversionteacherconfig' => $eventversionteacherconfig
        ]);
    }

}
