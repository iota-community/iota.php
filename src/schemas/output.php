<?php namespace iota\schemas;
/**
 * Class output
 *
 * @package iota\schemas
 */
class output extends \iota\schemas {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var array
   */
  public array $address;
  /**
   * @var int
   */
  public int $amount;
}