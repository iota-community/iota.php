<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiRequest;

/**
 * Class RequestSubmitMessage
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class RequestSubmitMessage extends AbstractApiRequest {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var string
   */
  public string $nonce = "0";

  /**
   * RequestSubmitMessage constructor.
   *
   * @param mixed $payload
   */
  public function __construct(public PayloadIndexation|PayloadTransaction $payload) {
  }
}