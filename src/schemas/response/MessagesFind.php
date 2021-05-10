<?php namespace iota\schemas\response;
/**
 * Class MessagesFind
 *
 * @package iota\schemas\response
 */
class MessagesFind extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $index;
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
  public array $messageIds;
}