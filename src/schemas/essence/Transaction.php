<?php namespace iota\schemas\essence;
/**
 * Class Transaction
 *
 * @package iota\schemas\essence
 */
class Transaction extends \iota\schemas\essence {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var \iota\schemas\payload|null
   */
  public ?\iota\schemas\payload $payload;
}