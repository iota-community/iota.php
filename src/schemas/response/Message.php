<?php namespace iota\schemas\response;
/**
 * Class Message
 *
 * @package iota\schemas\response
 */
class Message extends \iota\schemas\response {
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
  public \iota\schemas\payload\Indexation|\iota\schemas\payload\Transaction|\iota\schemas\payload\Milestone|\iota\schemas\payload\Receipt|\iota\schemas\payload\TreasuryTransaction $payload;
  /**
   * @var string
   */
  public string $nonce;
}