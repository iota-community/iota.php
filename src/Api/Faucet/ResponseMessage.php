<?php namespace IOTA\Api\Faucet;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseMessage
 *
 * @package      IOTA\Api\Faucet
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseMessage extends AbstractApiResponse {
  public string $message;

  /**
   *
   */
  protected function parse(): void {
    $input         = $this->input->__toArray();
    $this->message = $input['JSON'] ?? $input['message'];
  }
}