<?php

namespace Bilions;

use Bilions\Traits\AliPay;
use Bilions\Traits\Card;
use Bilions\Traits\Charge;
use Bilions\Traits\QRPay;
use Bilions\Traits\UnionPay;
use Exception;
use GuzzleHttp\Client;

class Kbank {

  use AliPay, Card, UnionPay, QRPay, Charge;

  /**
   * @var array $config
   */
  private $config;

  /**
   * @var string $baseurl
   */
  private $baseurl;

  /**
   * @var Client $http
   */
  private $http;

  /**
   * @var string $paymentType
   */
  public $paymentType;

  /**
   * @var string $dccCurrency
   */
  public $dccCurrency;

  /**
   * @var string $token
   */
  public $token = null;

  /**
   * class Constructor
   */
  public function __construct($config) {
    $this->config = $config;
  }

  /**
   * main function to get redirect Url
   */
  public function getRedirectUrl() {
    switch ($this->paymentType) {
    case 'card':
      return $this->getRedirectUrlForCard();
    case 'alipay':
      return $this->getRedirectUrlForAliPay();
    case 'unionpay':
      return $this->getRedirectUrlForUnionPay();
    }
  }

  /**
   * for thai qr payment
   */
  public function getQRPaymentOrderId() {
    return $this->getRedirectUrlForQRPay();
  }

  /**
   * overall api call
   * @param string $method
   * @param string $route
   * @param array $params
   */
  private function send($method, $route, $params) {
    try {
      $this->http = new Client([
        'base_uri' => $this->config['KBANK_BASE_URL'],
        'headers'  => [
          'x-api-key'    => $this->config['KBANK_API_KEY'],
          'Content-Type' => 'application/json',
        ],
      ]);
      $response = $this->http->request($method, $route, [
        'json' => $params,
      ]);
      $data = $response->getBody();
      return json_decode($data);
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      if ($e->getResponse() && $e->getResponse()->getBody()) {
        $error = json_decode($e->getResponse()->getBody(), true);
        if (isset($error['message'])) {
          throw new Exception($error['message']);
        } else {
          throw $e;
        }
      } else {
        throw $e;
      }
    }
  }

}