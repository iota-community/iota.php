<?php namespace IOTA\Api;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResposneArray
 *
 * @package      IOTA\Api
 * @author       StefanBraun @tanglePHP
 * @copyright    Copyright (c) 2022, StefanBraun
 */
class ResponseArray extends AbstractApiResponse {
  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}