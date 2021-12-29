<?php namespace IOTA\Client;

use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Helper\Converter;
use IOTA\Util\ApiCaller;
use IOTA\Api\v1\ResponseError;
use IOTA\Api\v1\ResponseInfo;
use IOTA\Api\v1\ResponseMessage;
use IOTA\Api\v1\ResponseMessageChildren;
use IOTA\Api\v1\ResponseMessageMetadata;
use IOTA\Api\v1\ResponseMessagesFind;
use IOTA\Api\v1\ResponseMilestone;
use IOTA\Api\v1\ResponseOutput;

/**
 * Class PermaNodeClient
 *
 * @package      IOTA\Client
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class PermaNodeClient {
  /**
   * @var ApiCaller
   */
  protected ApiCaller $ApiCaller;

  /**
   *
   */
  public function __construct() {
    $this->ApiCaller = (new ApiCaller('https://chrysalis-chronicle.iota.org/api/mainnet'));
  }

  /**
   * @return bool
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function health(): bool {
    return $this->info()->isHealthy;
  }

  /**
   * @return ResponseInfo|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function info(): ResponseInfo|ResponseError {
    return $this->ApiCaller->route('info')
                           ->callback(ResponseInfo::class)
                           ->fetchJSON();
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message.
   *
   * @param string $messageId
   *
   * @return ResponseMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function message(string $messageId): ResponseMessage|ResponseError {
    return $this->ApiCaller->route('messages/' . $messageId)
                           ->callback(ResponseMessage::class)
                           ->fetchJSON();
  }

  /**
   * Search for messages matching a given indexation key.
   *
   * @param string $index
   * @param bool   $_convertToHex
   *
   * @return ResponseMessagesFind|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function messagesFind(string $index, bool $_convertToHex = true): ResponseMessagesFind|ResponseError {
    return $this->ApiCaller->route('messages')
                           ->query(['index' => $_convertToHex ? Converter::string2Hex($index) : $index])
                           ->callback(ResponseMessagesFind::class)
                           ->fetchJSON();
  }

  /**
   * Returns the children of a message
   *
   * @param string $messageId
   *
   * @return ResponseMessageChildren|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function messageChildren(string $messageId): ResponseMessageChildren|ResponseError {
    return $this->ApiCaller->route('messages/' . $messageId . '/children')
                           ->callback(ResponseMessageChildren::class)
                           ->fetchJSON();
  }

  /**
   * Returns the metadata of a messages.
   *
   * @param string $messageId
   *
   * @return ResponseMessageMetadata|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function messageMetadata(string $messageId): ResponseMessageMetadata|ResponseError {
    return $this->ApiCaller->route('messages/' . $messageId . '/metadata')
                           ->callback(ResponseMessageMetadata::class)
                           ->fetchJSON();
  }

  /**
   * Returns information about a milestone
   *
   * @param int|string $index
   *
   * @return ResponseMilestone|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function milestone(int|string $index): ResponseMilestone|ResponseError {
    return $this->ApiCaller->route('milestones/' . $index)
                           ->callback(ResponseMilestone::class)
                           ->fetchJSON();
  }

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return ResponseOutput|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function output(string $outputId): ResponseOutput|ResponseError {
    return $this->ApiCaller->route('outputs/' . $outputId)
                           ->callback(ResponseOutput::class)
                           ->fetchJSON();
  }
}