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
   * @return mixed
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   */
  public function run(): mixed {
    $this->result = $returnValue = $this->client->messageSubmit(new PayloadIndexation($this->index, $this->data, $this->convertToHex));


    $this->callCallback($returnValue);

    return $this->result;
  }
}