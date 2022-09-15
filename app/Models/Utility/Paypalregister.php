<?php

namespace App\Models\Utility;

use App\Models\Payment;
use App\Models\Paymenttype;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paypalregister extends Model
{
    use HasFactory;

    private $eventversion;

    public function overpaymentByRegistrant($registrant)
    {
        $payments = $this->collected($registrant);

        $registrationfee = $this->registrationfee();

        $overpayment = ($payments) ? ($payments - $registrationfee) : 0;

        return $overpayment;
    }

    public function paymentsBySchool($school)
    {
        return Payment::where('school_id', $school->id)
            ->where('eventversion_id', $this->eventversion->id)
            ->where('paymenttype_id', Paymenttype::PAYPAL)
            ->sum('amount');
    }

    public function registrantsPaidBySchool($school)
    {
        $payments = Payment::where('eventversion_id', $this->eventversion->id)
            ->where('school_id', $school->id)
            ->get();
        
        $a = [];
        $uniques = $payments->filter(function($payment) use($a){
            
            if(! in_array($payment->registrant_id, $a)){
                
                //increment array
                $a[] = $payment->registrant_id;
                
                return true;
            }
            
            return false;
        });
        
        return count($uniques);
    }

    public function registrationfeeDueByRegistrant($registrant)
    {
        $payments = $this->collected($registrant);

        $registrationfee = $this->registrationfee();

        //overage will be reconciled in overpaymentsByRegistrants()
        return ($payments <= $registrationfee) ? $payments : $registrationfee;
    }

    public function registrationfeePaidByRegistrant($registrant)
    {
        $payments = $this->collected($registrant);

        $registrationfee = $this->registrationfee();

        //overage will be reconciled in overpaymentsByRegistrants()
        return ($payments <= $registrationfee) ? $payments : $registrationfee;
    }

    public function setEventversion($eventversion)
    {
        $this->eventversion= $eventversion;
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function collected($registrant)
    {
        return Payment::where('registrant_id', $registrant->id)
            ->where('eventversion_id', $this->eventversion->id)
            ->where('paymenttype_id', Paymenttype::PAYPAL)
            ->sum('amount');
    }

    private function registrationfee()
    {
        return $this->eventversion->eventversionconfigs->registrationfee;
    }


}
