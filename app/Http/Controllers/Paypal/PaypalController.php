<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;

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
        $enable_sandbox = false;
        //$this->ppipn->useSandbox();

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
    {
        if(isset($_POST) && count($_POST)){
Log::info('***** MAKE DTO *****');
            $dto = $this->makeDto();
Log::info('***** LOG POST INFO *****');
            $this->logPostInfo($dto);

            $payment = new Payment;
            $payment->recordIPNPayment($dto);

        }else{
            Log::info('*** PayPal IPN Testing: $_POST NOT found');
        }

        return header("HTTP/1.1 200 OK");
    }

    private function logPostInfo(array $dto)
    {
        $str = '*** START PayPal dto: '."/n/r";

        foreach($dto AS $key => $value){
            //$str .= $key.' => '.$value."/n/r";
            Log::info($key.' => '.$value);
        }

        $str .= '*** END PayPal dto ***';
    }

    private function makeDto(): array
    {
        Log::info('***** START RAW LOGGING *****');
        foreach($_POST AS $key => $value){
            Log::info($key.' => '.$value);
        }
        Log::info('***** END RAW LOGGING *****');

        /**
         * $parts contains the values for:
         * [
         *  0 => user_id,
         *  1 => registrant_id,
         *  2 => school_id,
         *  3 => vendor_id
         * ]
         */
        $parts = explode('*',$_POST['custom']);

        $a = [
            'payment_date' => $_POST['payment_date'],
            'payer' => $_POST['first_name'].' '.$_POST['last_name'],
            'payer_email' => $_POST['payer_email'],
            'payer_id' => $_POST['payer_id'],
            'address_name' => $_POST['address_name'],
            'address_street' => $_POST['address_street'],
            'address_city' => $_POST['address_city'],
            'address_state' => $_POST['address_state'],
            'address_zip' => $_POST['address_zip'],
            'item_name' => array_key_exists('item_name', $_POST) ? $_POST['item_name'] : 'item_name',
            'item_number' => array_key_exists('item_number', $_POST) ? $_POST['item_number'] : 'item_number',
            'item_name1' => array_key_exists('item_name1', $_POST) ? $_POST['item_name1'] : 'item_name1',
            'item_number1' => array_key_exists('item_number1', $_POST) ? $_POST['item_number1'] : 'item_number1',
            'amount' => $_POST['mc_gross'],
            'user_id' => $this->userId($parts),
            'eventversion_id' => $this->eventversionId($parts),
            'paymenttype_id' => 3, //Paymenttypes::PAYPAL
            'school_id' => $this->schoolId($parts),
            'vendor_id' => $_POST['verify_sign'],
        ];

        //only paypal payments from studentfolder.info contain a valid registrant_id
        if($parts[1] !== 'teacher'){

            $a['registrant_id'] = $this->registrantId($parts);
        }

        return $a;
    }

    private function eventversionId(array $parts)
    {
        return $parts[2];
    }

    private function registrantId(array $parts)
    {
        return $parts[1];
    }

    private function schoolId(array $parts)
    {
        return $parts[3];
    }

    private function userId(array $parts)
    {
        return $parts[0];
    }
}
