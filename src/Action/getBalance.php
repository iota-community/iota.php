<?php namespace IOTA\Action;

use IOTA\Models\AbstractAction;
use IOTA\Api\v1\ResponseBalanceAddress;
use IOTA\Api\v1\ResponseError;
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
   * @var string
   */
  protected string $address;
  /**
   * @var string
   */
  protected ?int $addressTyp;

  /**
   * @param string   $address
   * @param int|null $addressType
   *
   * @return $this
   * @throws ExceptionAction
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function address(string $address = '', ?int $addressType = null): self {
    $this->address    = $address;
    $this->addressTyp = $addressType;

    return $this;
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
  public function run(): ResponseBalanceAddress|ResponseError {
    // get addressType
    if($this->addressTyp === null) {
      $this->addressTyp = substr($this->address, 0, 4) == 'iota' || substr($this->address, 0, 4) == 'atoi' ? 1 : 0;
    }
    // check HRP
    if($this->addressTyp === 1 && substr($this->address, 0, 4) != ($this->client->info())->bech32HRP) {
      throw new ExceptionAction('wrong hrp address');
    }
    $this->result = $returnValue = match ($this->addressTyp) {
      1 => $this->client->address($this->address),
      0 => $this->client->addressEd25519($this->address),
      default => throw new ExceptionAction('unknown address type'),
    };
    $this->callCallback($returnValue);

    return $this->result;
  }

  /**
   * @return ResponseBalanceAddress|ResponseError
   */
  public function getResult(): ResponseBalanceAddress|ResponseError {
    return parent::getResult();
  }
}