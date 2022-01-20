<?php namespace IOTA\Api\v1;

use IOTA\Api\ResponseArray;
use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseOutputAddress
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseOutputAddress extends AbstractApiResponse {
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
  public ResponseArray $outputIds;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}