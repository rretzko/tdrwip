<?php

namespace App\Http\Controllers\Registrants;

use App\Events\FileuploadRejectionEvent;
use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Filecontenttype;
use App\Models\Fileupload;
use App\Models\Registrant;
use App\Models\Userconfig;
use App\Traits\UpdateRegistrantStatusTrait;
use App\Models\Utility\RegistrantTypeId;
use Carbon\Carbon;

class FileapprovalController extends Controller
{
    use UpdateRegistrantStatusTrait;

    public function approve(Registrant $registrant, Filecontenttype $filecontenttype)
    {
        Fileupload::where('registrant_id', $registrant->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->update([
                'approved' => Carbon::now(),
                'approved_by' => auth()->id()
            ]);

        if($registrant->eventversion_id > 72){

            /** @since 2022-09-28 */
            $this->updateRegistrantTypeId($registrant);

        }else {

            /** @deprecated */
            $this->updateRegistrantStatus($registrant);
        }

        return back();
    }

    public function reject(Registrant $registrant, Filecontenttype $filecontenttype)
    {
        $fileupload = Fileupload::where('registrant_id', $registrant->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->first();

        $fileupload->delete();

        if($registrant->eventversion_id > 72){

            /** @since 2022-09-28 */
            $this->updateRegistrantTypeId($registrant);

        }else {

            /** @deprecated */
            $this->updateRegistrantStatus($registrant);
        }

        event(new FileuploadRejectionEvent(
            Eventversion::find(Userconfig::getValue('eventversion', auth()->id())),
            $filecontenttype,
            $registrant ));

        return back();
    }

    private function updateRegistrantTypeId(Registrant $registrant)
    {
        $registrant_type_id = new RegistrantTypeId($registrant);

        $registrant->update(
            [
                'registranttype_id' => $registrant_type_id->registrantTypeId(),
            ]
        );
    }
}
