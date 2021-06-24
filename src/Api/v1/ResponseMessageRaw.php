<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseMessage
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseMessageRaw extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var mixed
   */
  public mixed $payload;
  /**
   * @var string
   */
  public string $nonce;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}