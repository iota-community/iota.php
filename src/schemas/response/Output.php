<?php namespace iota\schemas\response;
/**
 * Class Output
 *
 * @package iota\schemas\response
 */
class Output extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var string
   */
  public string $transactionId;
  /**
   * @var int
   */
  public int $outputIndex;
  /**
   * @var bool
   */
  public bool $isSpent;
  /**
   * @var array
   */
  public array $output;
}