<?php namespace IOTA\Action;

use IOTA\Models\AbstractAction;
use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseError;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Client\SingleNodeClient;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;

/**
 * Class sendMessage
 *
 * @package      IOTA\Action
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class sendMessage extends AbstractAction {
  /**
   * sendMessage constructor.
   *
   * @param SingleNodeClient $client
   * @param string           $index
   * @param string           $data
   * @param bool             $_convertToHex
   */
  public function __construct(protected SingleNodeClient $client, string $index = '', string $data = '', bool $_convertToHex = true) {
    parent::__construct($client, $index, $data, $_convertToHex);
  }

  /**
   * @param string $index
   * @param string $data
   * @param bool   $_convertToHex
   *
   * @return ResponseSubmitMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  protected function exec(string $index = '', string $data = '', bool $_convertToHex = true): ResponseSubmitMessage|ResponseError {
    return $this->client->messageSubmit(new PayloadIndexation($index, $data, $_convertToHex));
  }
}