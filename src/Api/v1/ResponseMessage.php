<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseMessage
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseMessage extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var ResponsePayloadIndexation
   */
  public ResponsePayloadIndexation $payload;
  /**
   * @var string
   */
  public string $nonce;

  /**
   *
   */
  protected function parse(): void {
    foreach($this->input->__toArray() as $_k => $_v) {
      $this->{$_k} = match ($_k) {
        'payload' => match ($_v['type']) {
          2 => new ResponsePayloadIndexation($_v),
        },
        default => $_v,
      };
    }
  }
}