<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseTips
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseTips extends AbstractApiResponse {
  /**
   * @var array
   */
  public array $tipMessageIds;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}