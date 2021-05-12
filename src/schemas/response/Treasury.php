<?php namespace iota\schemas\response;
/**
 * Class Treasury
 *
 * @package iota\schemas\response
 */
class Treasury extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $milestoneId;
  /**
   * @var int
   */
  public int $amount;
}