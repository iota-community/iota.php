<?php namespace IOTA;

use IOTA\Action\checkTransaction;
use IOTA\Action\getBalance;
use IOTA\Action\getMessage;
use IOTA\Action\sendMessage;
use IOTA\Action\sendTokens;
use IOTA\Client\FaucetClient;
use IOTA\Client\SingleNodeClient;

/**
 * Class Builder
 *
 * @package      IOTA
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Builder {
  /**
   * @var SingleNodeClient|FaucetClient
   */
  public SingleNodeClient|FaucetClient $client;
  /**
   * @var array|array[]
   */
  protected array $handles = [];

  /**
   * Builder constructor.
   */
  public function __construct() {
    $this->client();
  }

  /**
   * @param string          $handleKey
   * @param mixed           $val
   * @param string|int|null $name
   *
   * @return mixed
   */
  private function addHandle(string $handleKey, mixed $val, null|string|int $name = null): mixed {
    if(!isset($this->handles[$handleKey])) {
      $this->handles[$handleKey] = [];
    }
    if($name !== null) {
      return $this->handles[$handleKey][$name] ?? $this->handles[$handleKey][$name] = $val;
    }
    array_push($this->handles[$handleKey], $val);

    return $this->handles[$handleKey][array_key_last($this->handles[$handleKey])];
  }

  /**
   * @param string $client
   * @param string $API_ENDPOINT
   *
   * @return $this
   */
  public function client(string $client = 'SingleNodeClient', string $API_ENDPOINT = 'https://api.lb-0.testnet.chrysalis2.com'): self {
    $client       = "IOTA\Client\\" . $client;
    $this->client = new $client($API_ENDPOINT);

    return $this;
  }

  /**
   * @param int|string|null $name
   *
   * @return sendMessage
   */
  public function sendMessage(int|string|null $name = null): sendMessage {

    return $this->addHandle('sendMessage', new sendMessage($this->client), $name);
  }

  /**
   * @param int|string|null $name
   *
   * @return sendTokens
   */
  public function sendTokens(int|string|null $name = null): sendTokens {
    return $this->addHandle('sendTokens', new sendTokens($this->client), $name);
  }

  /**
   * @param int|string|null $name
   *
   * @return checkTransaction
   */
  public function checkTransaction(int|string|null $name = null): checkTransaction {
    return $this->addHandle('sendTokens', new checkTransaction($this->client), $name);
  }

  /**
   * @param int|string|null $name
   *
   * @return getBalance
   */
  public function getBalance(int|string|null $name = null): getBalance {
    return $this->addHandle('getBalance', new getBalance($this->client), $name);
  }

  /**
   * @param int|string|null $name
   *
   * @return getMessage
   */
  public function getMessage(int|string|null $name = null): getMessage {
    return $this->addHandle('getMessage', new getMessage($this->client), $name);
  }

  /**
   * @return array
   */
  public function run(): array {
    $ret = [];
    foreach($this->handles as $handleKey => $handleList) {
      $ret[$handleKey] = [];
      foreach($handleList as $handleListKey => $handle) {
        $ret[$handleKey][$handleListKey] = $handle->response ?? $handle->run();
      }
    }

    return $ret;
  }
}