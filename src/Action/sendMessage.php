<?php namespace IOTA\Action;

use IOTA\Api\v1\PayloadIndexation;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Helper\Converter;
use IOTA\Models\AbstractAction;
use IOTA\Models\AbstractApiResponse;

/**
 * Class sendMessage
 *
 * @package      IOTA\Action
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class sendMessage extends AbstractAction {
  /**
   *
   */
  const returnResponseMessage = 1;
  /**
   *
   */
  const returnResponseMessagePayload = 2;
  /**
   *
   */
  const returnResponseMessagePayloadData = 3;
  /**
   * @var string
   */
  protected string $index = '#iota.php';
  /**
   * @var string
   */
  protected string $data = 'message test! follow me on Twitter @IOTAphp';
  /**
   * @var bool
   */
  protected bool $convertToHex = true;
  /**
   * @var bool
   */
  protected bool $convertFromHex = true;

  /**
   * @param string $index
   *
   * @return $this
   */
  public function index(string $index): self {
    $this->index = $index;

    return $this;
  }

  /**
   * @param string $data
   *
   * @return $this
   */
  public function data(string $data): self {
    $this->data = $data;

    return $this;
  }

  /**
   * @param bool $convertToHex
   *
   * @return $this
   */
  public function convertToHex(bool $convertToHex = true): self {
    $this->convertToHex = $convertToHex;

    return $this;
  }

  /**
   * @param bool $convertFromHex
   *
   * @return $this
   */
  public function convertFromHex(bool $convertFromHex = true): self {
    $this->convertFromHex = $convertFromHex;

    return $this;
  }

  /**
   * @return mixed
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   */
  public function run(): mixed {
    $returnValue = $this->client->messageSubmit(new PayloadIndexation($this->index, $this->data, $this->convertToHex));
    switch($this->return) {
      case self::returnResponseMessage:
        $this->result = $this->client->message($returnValue->messageId);
        if($this->convertFromHex) {
          $this->result->payload->index = Converter::hex2String($this->result->payload->index);
          $this->result->payload->data  = Converter::hex2String($this->result->payload->data);
        }
        break;
      case self::returnResponseMessagePayload:
        $this->result = ($this->client->message($returnValue->messageId))->payload;
        if($this->convertFromHex) {
          $this->result->index = Converter::hex2String($this->result->index);
          $this->result->data  = Converter::hex2String($this->result->data);
        }
        break;
      case self::returnResponseMessagePayloadData:
        $this->result = ($this->client->message($returnValue->messageId))->payload->data;
        if($this->convertFromHex) {
          $this->result = Converter::hex2String($this->result);
        }
        break;
      default:
        $this->result = $returnValue;
        break;
    }
    $this->callCallback($returnValue);

    return $this->result;
  }
}