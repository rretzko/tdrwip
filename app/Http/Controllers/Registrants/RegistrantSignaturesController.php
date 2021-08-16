<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use App\Models\Signature;
use App\Models\Signaturetype;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistrantSignaturesController extends Controller
{
    public function update(Registrant $registrant)
    {
        //nullify the 'confirmed' value for the teacher's signature if it current exists
        if($registrant->hasSignatures){

            Signature::updateOrCreate(
                [
                    'registrant_id' => $registrant->id,
                    'signaturetype_id' => Signaturetype::TEACHER,
                ],
                [
                    'confirmed' => NULL,
                    'confirmed_by' => auth()->id(),
                ],
            );

        }else{//update the registrant's record with ALL signaturetypes

            foreach(Signaturetype::all() AS $signaturetype){

                Signature::updateOrCreate(
                    [
                        'registrant_id' => $registrant->id,
                        'signaturetype_id' => $signaturetype->id,
                    ],
                    [
                        'confirmed' => Carbon::now(),
                        'confirmed_by' => auth()->id(),
                    ],
                );
            }
        }

        return back();
    }
}
