<?php namespace iota\schemas\request;
/**
 * Class SubmitMessage
 *
 * @package iota\schemas\request
 */
class SubmitMessage extends \iota\schemas\request {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var \iota\schemas\payload
   */
  public \iota\schemas\payload $payload;
  /**
   * @var string
   */
  public string $nonce = "0";
}