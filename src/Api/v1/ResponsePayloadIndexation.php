<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePayloadIndexation
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponsePayloadIndexation extends AbstractApiResponse {
    /**
   * @var int
   */
  public int $type = 2;
  /**
   * @var string
   */
  public string $index = '';
  /**
   * @var string
   */
  public string $data = '';

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}