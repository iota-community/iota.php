<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class Response
 *
 * @package      IOTA\Api
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Response extends AbstractApiResponse {
  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}