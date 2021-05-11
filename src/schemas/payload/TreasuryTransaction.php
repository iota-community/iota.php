<?php namespace iota\schemas\payload;
/**
 * Class TreasuryTransaction
 *
 * @package iota\schemas\payload
 */
class TreasuryTransaction extends \iota\schemas\payload {
  /**
   * @var int
   */
  public int $type = 4;
  /**
   * @var array
   */
  public array $input;
  /**
   * @var array
   */
  public array $output;
}