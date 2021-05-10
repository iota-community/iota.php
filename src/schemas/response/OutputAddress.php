<?php namespace iota\schemas\response;
/**
 * Class OutputAddress
 *
 * @package iota\schemas\response
 */
class OutputAddress extends \iota\schemas\response {
  public int $addressType;
  public string $address;
  public int $maxResults;
  public int $count;
  public array $outputIds;
}