<?php namespace IOTA\Client;

use IOTA\Action\sendTokens;
use IOTA\Api\Faucet\ResponseMessage;
use IOTA\Api\Faucet\ResponseError;
use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Crypto\Mnemonic;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Type\Ed25519Seed;
use IOTA\Util\ApiCaller;

/**
 * Class FaucetClient
 *
 * @package      IOTA\Client
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class FaucetClient {
  /**
   * @var ApiCaller
   */
  protected ApiCaller $ApiCaller;

  /**
   * SingleNodeClient constructor.
   *
   * @throws ExceptionApi
   */
  public function __construct(protected string $API_ENDPOINT = 'https://faucet.testnet.chrysalis2.com') {
    $this->ApiCaller = (new ApiCaller($this->API_ENDPOINT));
  }

  /**
   * @param string $addressBech32
   *
   * @return ResponseMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function get(string $addressBech32): ResponseMessage|ResponseError {
    $ret = $this->ApiCaller->route('api')
                           ->query(['address' => $addressBech32])
                           ->settings('jsonData', 'message')
                           ->settings('jsonException', false)
                           ->callback(ResponseMessage::class)
                           ->fetchJSON();
    if(is_string($ret)) {
      $ret = new ResponseMessage(['message' => $ret]);
    }

    return $ret;
  }

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param int                               $_accountIndex
   * @param int                               $amount
   * @param PayloadIndexation|null            $_indexation
   *
   * @return sendTokens|ResponseSubmitMessage|ResponseError
   */
  public function send(Ed25519Seed|Mnemonic|string|array $seedInput, int $_accountIndex, int $amount, ?PayloadIndexation $_indexation = null): sendTokens|ResponseSubmitMessage|ResponseError {
    $build = (new sendTokens(new SingleNodeClient()))->amount($amount)
                                                     ->seedInput($seedInput)
                                                     ->accountIndex($_accountIndex)
                                                     ->toAddressBech32('atoi1qrk69lxuxljdgeqt7tucvtdfk3hrvrly7rzz65w57te6drf3expsj3gqrf9')
                                                     ->message("#iota.php", "transaction faucet resend! follow me on Twitter @IOTAphp");
    if($_indexation) {
      $build->payloadIndexation($_indexation);
    }

    return $build->run();
  }
}