<?php namespace iota\schemas;
/**
 * Class input
 *
 * @package iota\schemas
 */
class input extends \iota\schemas {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var array
   */
  public string $transactionId;
  /**
   * @var int
   */
  public int $transactionOutputIndex;
}