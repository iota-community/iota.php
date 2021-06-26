<?php namespace IOTA\Action;

use IOTA\Models\AbstractAction;
use IOTA\Api\v1\ResponseBalanceAddress;
use IOTA\Api\v1\ResponseError;
use IOTA\Client\SingleNodeClient;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Action as ExceptionAction;

/**
 * Class getBalance
 *
 * @package      IOTA\Action
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class getBalance extends AbstractAction {
  /**
   * getBalance constructor.
   *
   * @param SingleNodeClient $client
   * @param string           $address
   * @param int|null         $addressType
   */
  public function __construct(protected SingleNodeClient $client, string $address, int $addressType = null) {
    parent::__construct($client, $address, $addressType);
  }

  /**
   * @param string   $address
   * @param int|null $addressType
   *
   * @return ResponseBalanceAddress|ResponseError
   * @throws ExceptionAction
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  protected function exec(string $address = '', int $addressType = null): ResponseBalanceAddress|ResponseError {
    // get addressType
    if($addressType === null) {
      $addressType = substr($address, 0, 4) == 'iota' || substr($address, 0, 4) == 'atoi' ? 1 : 0;
    }
    // check HRP
    if($addressType === 1 && substr($address, 0, 4) != ($this->client->info())->bech32HRP) {
      throw new ExceptionAction('wrong hrp address');
    }

    return $this->return = match ($addressType) {
      1 => $this->client->address($address),
      0 => $this->client->addressEd25519($address),
      default => throw new ExceptionAction('unknown address type'),
    };
  }

  /**
   * @return ResponseBalanceAddress|ResponseError
   */
  public function getReturn(): ResponseBalanceAddress|ResponseError {
    return $this->return;
  }
}