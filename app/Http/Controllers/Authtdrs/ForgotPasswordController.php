<?php

namespace App\Http\Controllers\Authtdrs;

use App\Events\SubscriberPasswordResetEvent;
use App\Http\Controllers\Controller;
use App\Models\Subscriberemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = Subscriberemail::where('email', $request['email'])->first();

        if($email) {
            event(new SubscriberPasswordResetEvent($email));
        }

        return ($email)
            ? back()->with(['status' => __('Please check your in-box at '.$email->email.' for your Password Reset link.')])
            : back()->withErrors(__('The email address: '.$request['email'].'was not found.'));
    }
}
