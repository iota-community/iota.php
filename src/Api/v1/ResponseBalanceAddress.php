<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseBalanceAddress
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseBalanceAddress extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $addressType;
  /**
   * @var string
   */
  public string $address;
  /**
   * @var int
   */
  public int $balance;
  /**
   * @var bool
   */
  public bool $dustAllowed;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}