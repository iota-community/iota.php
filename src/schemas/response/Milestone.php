<?php namespace iota\schemas\response;
/**
 * Class Milestone
 *
 * @package iota\schemas\response
 */
class Milestone extends \iota\schemas\response {
  /**
   * @var int
   */
  public int $index;
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var int
   */
  public int $timestamp;
}