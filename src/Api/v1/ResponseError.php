<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseError
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseError extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $code;
  /**
   * @var string
   */
  public string $message;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}