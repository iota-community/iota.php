<?php namespace iota\schemas\payload;
/**
 * Class Transaction
 *
 * @package iota\schemas\payload
 */
class Transaction extends \iota\schemas\payload {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var string
   */
  public \iota\schemas\essence $essence;
  /**
   * @var string
   */
  public array $unlockBlocks;
}