#### USAGE

<strong>`paymentType`</strong>\
(Possible Payment Type)

- qr
- alipay
- unionpay
- card

<strong>`dccCurrency`</strong> (Optional)\
Other Currency. Example - (USD)

<strong>`amount`</strong>\
Amount to charge. Example - (100)

<strong>`currency`</strong>\
Currency. Example - (THB) currently kbank only support THB

<strong>`description`</strong>\
Order Description.

<strong>`referenceOrder`</strong>\
Unique Order Number.

<strong>`token`</strong> (Optional)\
Request Token for Card (required only for card payment)

<strong>`getRedirectUrl()`</strong>\
Get redirect url for `alipay`, `card` and `unionpay` payment methods

<strong>`getQRPaymentOrderId()`</strong>\
Get redirect orderDetail for `thai qr` payment method

<strong>`getCharge($chargeId)`</strong>\
Get change detail for all kind of payments including qr

---

###### Example Usage

```
<?php

use Bilions\Kbank;

require __DIR__ . "/vendor/autoload.php";

$config = [
  'KBANK_BASE_URL' => $_ENV['KBANK_BASE_URL'],
  'KBANK_API_KEY'  => $_ENV['KBANK_API_KEY'],
  'KBANK_MID'      => $_ENV['KBANK_MID'],
  'KBANK_TID'      => $_ENV['KBANK_TID'],
];

$kbank                 = new Kbank($config);
$kbank->paymentType    = 'qr';
$kbank->amount         = 100;
$kbank->currency       = 'THB';
$kbank->description    = 'Description Here';
$kbank->referenceOrder = uniqid();
$kbank->token          = '{your-request-token-here}'; // only for card payment

$result = $kbank->getRedirectUrl();
$result = $kbank->getQRPaymentOrderId();
$result = $kbank->getCharge('{your-request-token-here}');

print_r($result);

```

###### QR Front End

```
<form method="POST" action="/payment/qr">
    <script type="text/javascript"
    src="https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js"
    data-apikey="{{apiKey}}"
    data-amount="{{price}}"
    data-payment-methods="qr"
    data-order-id="{{orderId}}"
    data-name="Your Company Name"
    data-show-button="false"
    >
    </script>
</form>
$(document).ready(function() {
    KPayment.show()
})
```

###### Card Front End

```
<form id="form" method="POST" action="/api/payment/card">
  <script type="text/javascript"
    src="https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js"
    data-apikey="{{apiKey}}"
    data-amount="{{price}}"
    data-currency="THB"
    data-payment-methods="card"
    data-name="Your Company Name"
    data-show-button="false"
    data-mid="{{mid}}">
  </script>
  <button class="pay-button" type="button" onclick="KPayment.show()">
  <span class="btn-text">Credit / Debit Card</span>
  </button>
</form>
```

###### Other Payment method

- for other payment method you can just redirect url
