<?php namespace iota\client;
/**
 * Class faucet
 *
 * @package iota\client
 */
class faucet extends \iota\client {
  public function __construct() {
    $this->API_ENDPOINT = "https://faucet.testnet.chrysalis2.com/";
    $this->_options     = [];
  }

  /**
   * @param string $addressBech32
   *
   * @return string
   * @throws \Exception
   */
  public function get(string $addressBech32) {
    return (new \iota\api($this))->fetch([
      'route' => "/api",
      'query' => ['address' => $addressBech32],
    ])['message'];
  }

  /**
   * @param \iota\type\seed\ed25519                $walletSeed
   * @param int                                    $_accountIndex
   * @param int                                    $amount
   * @param false|\iota\schemas\payload\Indexation $_indexation
   *
   * @return \iota\schemas\response\SubmitMessage
   * @throws \SodiumException
   * @throws \iota\exception\converter
   */
  public function send(\iota\type\seed\ed25519 $walletSeed, int $_accountIndex, $amount = 100000, false|\iota\schemas\payload\Indexation $_indexation = false): \iota\schemas\response\SubmitMessage {

    return (new \iota('https://api.lb-0.testnet.chrysalis2.com'))->send($walletSeed, $_accountIndex, "atoi1qrk69lxuxljdgeqt7tucvtdfk3hrvrly7rzz65w57te6drf3expsj3gqrf9", $amount, $_indexation);
  }
}

