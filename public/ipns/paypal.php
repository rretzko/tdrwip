<?php namespace Listener;

require('PaypalIPN.php');

use PaypalIPN;

$ipn = new PaypalIPN();

$ipn->sendLog();

header("HTTP/1.1 200 OK");
