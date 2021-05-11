<?php namespace iota\schemas\payload;
/**
 * Class Indexation
 *
 * @package iota\schemas\payload
 */
class Receipt extends \iota\schemas\payload {
  /**
   * @var int
   */
  public int $type = 3;
  /**
   * @var int
   */
  public int $migratedAt;
  /**
   * @var bool
   */
  public bool $final;
  /**
   * @var array
   */
  public array $funds;
  /**
   * @var TreasuryTransaction
   */
  public \iota\schemas\payload\TreasuryTransaction $transaction;
}