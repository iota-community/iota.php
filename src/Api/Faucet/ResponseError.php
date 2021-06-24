<?php namespace IOTA\Api\Faucet;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseError
 *
 * @package      IOTA\Api\Faucet
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseError extends AbstractApiResponse {
  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}