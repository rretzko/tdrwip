<?php

namespace App\Models\Utility;

use App\Models\Application;
use App\Models\Eapplication;
use App\Models\Eventversion;
use App\Models\Fileupload;
use App\Models\Registrant;
use App\Models\Registranttype;
use App\Models\Signature;

/**
 * Return registranttypeid for registrant based on application, instrumentation, signatures and file-upload states
 *
 */

class RegistrantTypeId
{
    private $eventversion;
    private $filecontenttypes_count;
    private $has_application;
    private $has_file_uploads;
    private $has_instrumentation;
    private $has_signatures;
    private $registrant;
    private $registrant_type_id;

    public function __construct(Registrant $registrant)
    {
        $this->registrant = $registrant;
        $this->eventversion = Eventversion::find($registrant->eventversion_id);
        $this->filecontenttypes_count = $this->eventversion->filecontenttypes->count();

        $this->hasApplication();
        $this->hasInstrumentation();
        $this->hasSignatures();
        $this->hasFileUploads();
        $this->calcStatusId();
    }

    public function registrantTypeId()
    {
        return $this->registrant_type_id;
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function calcStatusId(): void
    {
        if($this->registrant->registranttype_id === Registranttype::PROHIBITED) {

            $this->registrant_type_id = Registranttype::PROHIBITED;

        }elseif(
            $this->has_application &&
            $this->has_instrumentation &&
            $this->has_signatures &&
            $this->has_file_uploads
        ){

            $this->registrant_type_id = Registranttype::REGISTERED;

        }elseif($this->has_application){

            $this->registrant_type_id = Registranttype::APPLIED;

        }else{

            $this->registrant_type_id = Registranttype::ELIGIBLE;
        }
    }

    private function hasApplication(): void
    {
        $this->has_application = $this->eventversion->eventversionconfigs->eapplication

            ? Eapplication::where('registrant_id', $this->registrant->id)
                ->exists()

            : Application::where('registrant_id', $this->registrant->id)
                ->exists();
    }

    private function hasFileUploads(): void
    {
        $this->has_file_uploads = (! $this->eventversion->eventversionconfigs->virtualaudition)

            ? true //eventversion does not include file uploads

            : Fileupload::where('registrant_id',$this->registrant->id)
                ->whereNotNull('approved')
                ->count() === $this->filecontenttypes_count;
    }

    private function hasInstrumentation(): void
    {
        $this->has_instrumentation = $this->registrant->instrumentations->count();
    }

    private function hasSignatures(): void
    {
        $this->has_signatures = $this->eventversion->eventversionconfigs->eapplication

            ? Eapplication::where('registrant_id', $this->registrant->id)
                ->where('signatureguardian', 1)
                ->where('signaturestudent', 1)
                ->exists()

            : Signature::where('registrant_id', $this->registrant->id)
                ->whereNotNull('confirmed')
                ->count() === $this->eventversion->eventversionconfigs->signature_count;
    }



}
