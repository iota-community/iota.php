<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePayloadTransaction
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponsePayloadTransaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var ResponseEssenceTransaction
   */
  public ResponseEssenceTransaction $essence;
  /**
   * @var array
   */
  public array $unlockBlocks;

  /**
   *
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      $this->{$_k} = match ($_k) {
        'essence' => match ($_v['type']) {
          0 => new ResponseEssenceTransaction($_v),
        },
        default => $_v,
      };
    }
  }
}