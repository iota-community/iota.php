<?php namespace iota\schemas\response;
/**
 * Class BalanceAddress
 *
 * @package iota\schemas\response
 */
class BalanceAddress extends \iota\schemas\response {
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
}