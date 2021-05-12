<?php namespace iota\schemas\response;
/**
 * Class OutputAddress
 *
 * @package iota\schemas\response
 */
class OutputAddress extends \iota\schemas\response {
  /**
   * @var int
   */
  public int $addressType;
  /**
   * @var string
   */
  public string $address;
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
  public array $outputIds;
}