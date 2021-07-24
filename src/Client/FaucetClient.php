<?php namespace IOTA\Client;

use IOTA\Action\sendTokens;
use IOTA\Api\Faucet\ResponseMessage;
use IOTA\Api\Faucet\ResponseError;
use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Crypto\Mnemonic;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Exception\Type as ExceptionType;
use SodiumException;
use IOTA\Helper\Amount;
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
  public function __construct() {
    $this->ApiCaller = (new ApiCaller('https://faucet.testnet.chrysalis2.com'));
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
    if(is_null($ret)) {
      $ret = new ResponseError(['error'   => '902',
                                'message' => 'FaucetServer timeout',
      ]);
    }

    return $ret;
  }

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param int                               $_accountIndex
   * @param int|string|Amount                 $amount
   * @param PayloadIndexation|null            $_indexation
   *
   * @return sendTokens|ResponseSubmitMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function send(Ed25519Seed|Mnemonic|string|array $seedInput, int $_accountIndex, int|string|Amount $amount, ?PayloadIndexation $_indexation = null): sendTokens|ResponseSubmitMessage|ResponseError {
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