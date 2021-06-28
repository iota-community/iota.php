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
   * @var ResponsePayloadIndexation|null
   */
  public ?ResponsePayloadIndexation $payload;

  /**
   *
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      $this->{$_k} = match ($_k) {
        'payload' => match ($_v['type']) {
          2 => new ResponsePayloadIndexation($_v),
          default => $_v,
        },
        default => $_v,
      };
    }
  }
}