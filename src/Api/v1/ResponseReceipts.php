<?php namespace IOTA\Api\v1;

use IOTA\Api\ResponseArray;
use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseReceipts
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseReceipts extends AbstractApiResponse {
  /**
   * @var array
   */
  public ResponseArray $receipts;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}