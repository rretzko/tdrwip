<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    private $ppipn;
    private $enable_sandbox;
    private $my_email_addresses;
    private $send_confirmation_email;
    private $send_confirmation_email_address;
    private $send_confirmation_email_from_address;
    private $save_log_file;

    public function __construct()
    {Log::info('Got to controller! @ '.__METHOD__);
        $this->ppipn = new \App\Models\Paypal\PaypalIPN();

        //set sandbox to true
        $enable_sandbox = true;
        $this->ppipn->useSandbox();

        //valid email addresses for business
        $my_email_addresses =
            [
                'morrisareahonorchoir@gmail.com',
                'rick@mfrholdings.com',
            ];

        //send confirmation email to user
        $this->send_confirmation_email = true;
        $this->send_confirmation_email_address = 'Rick Retzko <rick@mfrholdings.com>';
        $this->send_confirmation_email_from_address = 'PayPal IPN <rick@mfrholdings.com>';

        //create a log of the transaction
        $this->save_log_file = true;
    }
    public function update()
    {return header("HTTP/1.1 200 OK");
        Log::info('Got to controller! @ '.__METHOD__);
        //enable Sandbox or not
        if($this->enable_sandbox){ $this->ppipn->useSandbox();}

        $verified = $this->ppipn->verifyIPN();

        //create string of data
        $data_text = "";
        foreach($_POST as $key => $value){
            $data_text .= $key.' = '.$value."\r\n";
        }

        //???
        $test_text = "";
        if($_POST['text_ipn'] === 1){
            $test_text = "Test";
        }

        //confirm that verified business email is sent
        $receiver_email_found = false;
        foreach($this->my_email_addresses AS $email){
            if(strtolower($_POST["receiver_email"] === $email)){

                $receiver_email_found = true;
                break;
            }
        }

        date_default_timezone_set("America/New_York");
        list($year,$month,$day,$hour,$minute,$second,$timezone) = explode(":",date("Y:m:d:H:i:s:"));
        $date = $year."-".$month."_".$day;
        $timestamp = $date." ".$hour.":".$minute.":".$second." ".$timezone;
        //$dated_log_file_dir = $log_file_dir."/".$year."/".$month;
        $paypal_ipn_status = "VERIFICATION FAILED";

        if($verified){
            $paypal_ipn_status = "RECEIVER EMAIL MISMATCH";
            if($receiver_email_found){
                $paypal_ipn_status = "Completed Successfully";
                //Process IPN
                //A list of variables are available here;
                //https://developer.paypal.com/webapps/developer/docs/classic/ipn/integuide/IPNandPDTVariables/
            }
        }

        Log::info(Carbon::now().': paypal transaction received');

        Log::info(serialize($_POST));

    }
}
