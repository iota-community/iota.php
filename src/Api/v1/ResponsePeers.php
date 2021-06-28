<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePeers
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponsePeers extends AbstractApiResponse {
  /**
   * @var array
   */
  public array $data;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}