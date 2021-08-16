<?php

namespace App\Http\Controllers\Registrants;

use App\Events\FileuploadRejectionEvent;
use App\Http\Controllers\Controller;
use App\Models\Eventversion;
use App\Models\Filecontenttype;
use App\Models\Fileupload;
use App\Models\Registrant;
use App\Models\Userconfig;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileapprovalController extends Controller
{
    public function approve(Registrant $registrant, Filecontenttype $filecontenttype)
    {
        Fileupload::where('registrant_id', $registrant->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->update([
                'approved' => Carbon::now(),
                'approved_by' => auth()->id()
            ]);

        return back();
    }

    public function reject(Registrant $registrant, Filecontenttype $filecontenttype)
    {
        Fileupload::where('registrant_id', $registrant->id)
            ->where('filecontenttype_id', $filecontenttype->id)
            ->update([
                'approved' => NULL,
                'approved_by' => auth()->id()
            ]);



        event(new FileuploadRejectionEvent(
            Eventversion::find(Userconfig::getValue('eventversion', auth()->id())),
            $filecontenttype,
            $registrant ));

        return back();
    }
}
