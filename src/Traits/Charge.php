<?php

namespace Bilions\Traits;

use Exception;

trait Charge {
  /**
   * get charge data
   */
  public function getCharge($chargeId) {
    try {
      $url = $this->paymentType == 'qr' ? '/qr/v2/qr/' : '/card/v2/charge/';
      return $this->send('GET', $url . $chargeId, []);
    } catch (Exception $e) {
      throw $e;
    }
  }
}
