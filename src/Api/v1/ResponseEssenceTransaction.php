<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePayloadIndexation
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseEssenceTransaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var array
   */
  public array $payload;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}