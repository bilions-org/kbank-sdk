<?php

use Bilions\Kbank;

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$kbank                 = new Kbank($_ENV);
$kbank->paymentType    = 'qr'; // alipay
$kbank->amount         = 100;
$kbank->currency       = 'THB';
$kbank->description    = 'Description';
$kbank->referenceOrder = uniqid();
$kbank->token          = '{your-request-token-here}'; // only for card payment

// $result = $kbank->getRedirectUrl();
// $result = $kbank->getQRPaymentOrderId();
$result = $kbank->getCharge('{your-request-token-here}');
print_r($result->id);