<?php namespace IOTA\Action;

use IOTA\Api\v1\ResponseError;
use IOTA\Api\v1\ResponseMessage;
use IOTA\Api\v1\ResponsePayloadIndexation;
use IOTA\Api\v1\ResponsePayloadTransaction;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Helper\Converter;
use IOTA\Models\AbstractAction;

/**
 * Class getMessage
 *
 * @package      IOTA\Action
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class getMessage extends AbstractAction {
  /**
   * @var bool
   */
  protected bool $convertHex = true;
  /**
   * @var string
   */
  protected string $messageId;

  /**
   * @param string $messageId
   *
   * @return $this
   */
  public function messageId(string $messageId): self {
    $this->messageId = $messageId;

    return $this;
  }

  /**
   * @param bool $convertHex
   *
   * @return $this
   */
  public function convertHex(bool $convertHex = true): self {
    $this->convertHex = $convertHex;

    return $this;
  }

  /**
   * @return ResponseMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   */
  public function run(): ResponseMessage|ResponseError {
    $this->result = $returnValue = $this->client->message($this->messageId);
    if($this->convertHex && $this->result instanceof ResponseMessage && isset($this->result->payload)) {

      if($this->result->payload instanceof ResponsePayloadIndexation) {
        $this->result->payload->index = Converter::hex2String($this->result->payload->index);
        $this->result->payload->data  = Converter::hex2String($this->result->payload->data);
      }
      if($this->result->payload instanceof ResponsePayloadTransaction) {
        if(isset($this->result->payload->essence->payload)) {
          $this->result->payload->essence->payload->index = Converter::hex2String($this->result->payload->essence->payload->index);
          $this->result->payload->essence->payload->data  = Converter::hex2String($this->result->payload->essence->payload->data);
        }
      }
    }
    $this->callCallback($returnValue);

    return $this->result;
  }
}