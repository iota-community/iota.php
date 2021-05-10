<?php namespace iota\schemas\response;
/**
 * Class MessageChildren
 *
 * @package iota\schemas\response
 */
class MessageChildren extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var int
   */
  public int $maxResults;
  /**
   * @var int
   */
  public int $count;
  /**
   * @var array
   */
  public array $childrenMessageIds;
}