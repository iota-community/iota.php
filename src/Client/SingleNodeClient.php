<?php namespace IOTA\Client;

use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Helper\Converter;
use IOTA\Helper\JSON;
use IOTA\Util\ApiCaller;
use IOTA\Api\v1\ResponseError;
use IOTA\Api\v1\ResponseInfo;
use IOTA\Api\v1\ResponseTips;
use IOTA\Api\v1\ResponseMessage;
use IOTA\Api\v1\ResponseMessageChildren;
use IOTA\Api\v1\ResponseMessageMetadata;
use IOTA\Api\v1\ResponseMessagesFind;
use IOTA\Api\v1\ResponseMilestone;
use IOTA\Api\v1\ResponseMilestoneUtxoChanges;
use IOTA\Api\v1\ResponsePeers;
use IOTA\Api\v1\ResponsePeer;
use IOTA\Api\v1\ResponseOutput;
use IOTA\Api\v1\ResponseBalanceAddress;
use IOTA\Api\v1\ResponseOutputAddress;
use IOTA\Api\v1\ResponseReceipts;
use IOTA\Api\v1\ResponseTreasury;
use IOTA\Api\v1\RequestAddPeer;
use IOTA\Api\v1\RequestSubmitMessage;

/**
 * Class SingleNodeClient
 *
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class SingleNodeClient {
  /**
   * @var ApiCaller
   */
  protected ApiCaller $ApiCaller;

  /**
   * SingleNodeClient constructor.
   *
   * @throws ExceptionApi
   */
  public function __construct(protected string $API_ENDPOINT = 'https://api.lb-0.testnet.chrysalis2.com') {
    $this->ApiCaller = (new ApiCaller($this->API_ENDPOINT))->basePath('api/v1/');
  }

  /**
   * @throws ExceptionApi
   */
  public function health(): bool {
    $status = $this->ApiCaller->route('/health')
                              ->fetchStatus();

    return match ($status['http_code']) {
      200 => true,
      503 => false,
      default => throw new ExceptionApi("/health unexpected response code '{$status['http_code']}'"),
    };
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
   * @return ResponseTips|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function tips(): ResponseTips|ResponseError {
    return $this->ApiCaller->route('tips')
                           ->callback(ResponseTips::class)
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
   * Submits a message to the node
   *
   * @param RequestSubmitMessage|PayloadIndexation $message
   *
   * @return ResponseSubmitMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function messageSubmit(RequestSubmitMessage|PayloadIndexation $message): ResponseSubmitMessage|ResponseError {
    if($message instanceof PayloadIndexation) {
      $message = new RequestSubmitMessage($message);
    }

    return $this->ApiCaller->route('messages')
                           ->method('POST')
                           ->requestData($message->__toJSON())
                           ->callback(ResponseSubmitMessage::class)
                           ->fetchJSON();
  }

  /**
   * @param string $messageId
   *
   * @return string|JSON|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function messageRaw(string $messageId): string|JSON|ResponseError {
    return $this->ApiCaller->route('messages/' . $messageId . '/raw')
                           ->fetchBinary();
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
   * @param string $index
   *
   * @return ResponseMilestone|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function milestone(string $index): ResponseMilestone|ResponseError {
    return $this->ApiCaller->route('milestones/' . $index)
                           ->callback(ResponseMilestone::class)
                           ->fetchJSON();
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param string $index
   *
   * @return ResponseMilestoneUtxoChanges|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function milestoneUtxoChanges(string $index): ResponseMilestoneUtxoChanges|ResponseError {
    return $this->ApiCaller->route('milestones/' . $index . '/utxo-changes')
                           ->callback(ResponseMilestoneUtxoChanges::class)
                           ->fetchJSON();
  }

  /**
   * Returns all peers of the node
   *
   * @return ResponsePeers|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function peers(): ResponsePeers|ResponseError {
    return $this->ApiCaller->route('peers')
                           ->callback(ResponsePeers::class)
                           ->fetchJSON();
  }

  /**
   * Returns a given peer of the node
   *
   * @param string $peerId
   *
   * @return ResponsePeer|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function peer(string $peerId): ResponsePeer|ResponseError {
    return $this->ApiCaller->route('peers/' . $peerId)
                           ->callback(ResponsePeer::class)
                           ->fetchJSON();
  }

  /**
   * Adds a given peer to the node
   *
   * @param string      $multiAddress
   * @param string|null $alias
   *
   * @return ResponsePeer|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function peerAdd(string $multiAddress, string $alias = null): ResponsePeer|ResponseError {
    return $this->ApiCaller->route('peers')
                           ->method('POST')
                           ->requestData((new RequestAddPeer($multiAddress, $alias))->__toJSON())
                           ->callback(ResponsePeer::class)
                           ->fetchJSON();
  }

  /**
   * Remove/disconnect a given peer.
   *
   * @param string $peerId
   *
   * @return ResponseError|null
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function peerDelete(string $peerId): null|ResponseError {
    $ret = $this->ApiCaller->route('peers/' . $peerId)
                           ->method('DELETE')
                           ->fetchJSON();
    if($ret instanceof ResponseError) {
      return $ret;
    }

    return null;
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

  /**
   * Get the balance of a bech32-encoded address.
   *
   * @param string $addressBech32
   *
   * @return ResponseBalanceAddress|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function address(string $addressBech32): ResponseBalanceAddress|ResponseError {
    return $this->ApiCaller->route('addresses/' . $addressBech32)
                           ->callback(ResponseBalanceAddress::class)
                           ->fetchJSON();
  }

  /**
   * Get all outputs that use a given bech32-encoded address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressBech32
   * @param int    $type
   * @param bool   $includeSpend
   *
   * @return ResponseBalanceAddress|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function addressesOutput(string $addressBech32, int $type = 0, bool $includeSpend = false): ResponseOutputAddress|ResponseError {
    return $this->ApiCaller->route('addresses/' . $addressBech32 . '/outputs')
                           ->query([
                             'include-spent' => $includeSpend,
                             'type'          => $type,
                           ])
                           ->callback(ResponseOutputAddress::class)
                           ->fetchJSON();
  }

  /**
   * Get the balance of a hex-encoded Ed25519 address.
   *
   * @param string $addressEd25519
   *
   * @return ResponseBalanceAddress|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function addressEd25519(string $addressEd25519): ResponseBalanceAddress|ResponseError {
    return $this->ApiCaller->route('addresses/ed25519/' . $addressEd25519)
                           ->callback(ResponseBalanceAddress::class)
                           ->fetchJSON();
  }

  /**
   * Get all outputs that use a given hex-encoded Ed25519 address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressEd25519
   * @param int    $type
   * @param bool   $includeSpend
   *
   * @return ResponseOutputAddress|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function addressesed25519Output(string $addressEd25519, int $type = 0, bool $includeSpend = false): ResponseOutputAddress|ResponseError {
    return $this->ApiCaller->route('addresses/ed25519/' . $addressEd25519 . '/outputs')
                           ->query([
                             'include-spent' => $includeSpend,
                             'type'          => $type,
                           ])
                           ->callback(ResponseOutputAddress::class)
                           ->fetchJSON();
  }

  /**
   * Get all the stored receipts or those for a given migrated at index.
   *
   * @param int|null $migratedAt
   *
   * @return ResponseReceipts|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function receipts(?int $migratedAt = null): ResponseReceipts|ResponseError {
    return $this->ApiCaller->route('receipts' . ($migratedAt ? '/' . $migratedAt : ''))
                           ->callback(ResponseReceipts::class)
                           ->fetchJSON();
  }

  /**
   * Returns information about the treasury
   *
   * @return ResponseReceipts|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function treasury(): ResponseTreasury|ResponseError {
    return $this->ApiCaller->route('treasury')
                           ->callback(ResponseTreasury::class)
                           ->fetchJSON();
  }
}