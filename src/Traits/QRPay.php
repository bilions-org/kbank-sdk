<?php

namespace Bilions\Traits;

trait QRPay {
  /**
   * get redirect url for card or aliPay
   */
  private function getRedirectUrlForQRPay() {
    try {
      $params = [
        'amount'          => $this->amount,
        'currency'        => $this->currency,
        'description'     => $this->description,
        'source_type'     => $this->paymentType,
        'reference_order' => $this->referenceOrder,
        'ref_1'           => $this->ref1 ?? null,
        'ref_2'           => $this->ref2 ?? null,
      ];
      return $this->send('POST', '/qr/v2/order', $params);
    } catch (Exception $e) {
      throw $e;
    }
  }
}
