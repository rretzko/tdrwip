<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    public function update($request)
    {
        Log::info(Carbon::now().': paypal transaction received');
    }
}
