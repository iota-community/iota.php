<?php namespace IOTA;

use IOTA\Action\getMessage;
use IOTA\Action\sendMessage;
use IOTA\Api\v1\ResponseError;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Client\SingleNodeClient;
use IOTA\Crypto\Ed25519;
use IOTA\Helper\Converter;
use IOTA\Helper\Hash;
use IOTA\Identity\Authentication;
use IOTA\Identity\Document;
use IOTA\Identity\Result;
use IOTA\Identity\Service;
use IOTA\Identity\Uri;
use IOTA\Util\Keys;
use IOTA\Util\Network;
use IOTA\Exception\Identity as ExceptionIdentity;
use SodiumException;

/**
 * Class Identity
 *
 * @package      IOTA
 * @author       StefanBraun <stefan.braun@sourcl.com>
 * @copyright    Copyright (c) 2021, StefanBraun
 * @version      2021.07.19
 */
class Identity {
  /**
   * @var Network
   */
  protected Network $network;
  /**
   * @var Uri
   */
  protected Uri $uri;
  /**
   * @var Keys
   */
  protected Keys $keys;

  /**
   * @param string|Uri|null        $uriInput
   * @param Keys|array|string|null $keyInput
   * @param string|array|Network   $network
   *
   * @throws ExceptionIdentity
   * @throws Exception\Api
   * @throws Exception\Converter
   * @throws Exception\Helper
   * @throws Exception\Util
   * @throws SodiumException
   */
  public function __construct(string|Uri|null $uriInput = null, Keys|array|string $keyInput = null, string|array|Network|null $network = null) {

    $this->keys    = new Keys($keyInput ?? Ed25519::keyPair());
    $this->network = new Network($network);
    // Uri
    if($uriInput instanceof Uri) {
      $this->uri = $uriInput;
    }
    elseif(is_string($uriInput) && str_contains($uriInput, ':')) {
      $this->uri = Uri::parse($uriInput);
    }
    elseif(is_string($uriInput) && !str_contains($uriInput, ':')) {
      $this->uri = new Uri('iota', $uriInput);
    }
    elseif($uriInput == null) {
      $this->uri = new Uri('iota', self::createID($this->keys->public));
    }
    if($this->uri->getId() !== self::createID($this->keys->public)) {
      throw new ExceptionIdentity('Differences in DID found');
    }
  }

  /**
   * @param string $publicKey
   *
   * @return string
   * @throws Exception\Converter
   * @throws SodiumException
   */
  static public function createID(string $publicKey): string {
    return Converter::base58_encode(Hash::blake2b_sum256($publicKey));
  }

  /**
   * @return false|Result
   * @throws ExceptionIdentity
   * @throws Exception\Api
   * @throws Exception\Converter
   * @throws Exception\Helper
   */
  public function checkIdIndexTangleExists(): false|Result {
    $client = new SingleNodeClient($this->network);
    $found  = ($client)->messagesFind($this->uri->getId());
    if(count($found->messageIds) == 0) {
      return false;
    }
    $messageId = $found->messageIds[0];
    //
    $message = (new getMessage($client))->messageId($messageId)
                                        ->run();
    if($message instanceof ResponseError) {
      throw new ExceptionIdentity("Unknown messageId '$messageId'");
    }
    //
    $result               = new Result();
    $result->uri          = $this->uri;
    $result->keys         = $this->keys;
    $result->explorerLink = $this->network->getExplorerUrlMessage($messageId);
    $result->messageId    = $messageId;
    $result->document     = Document::fromJson($message->payload->data);

    if($this->uri->getDid() !== $result->document->id) {
      throw new ExceptionIdentity("Uri conflict '{$this->uri->getDid()}' '{$result->document->id}'");
    }

    return $result;
  }

  /**
   * @param string|null $fragment
   *
   * @return Result
   * @throws ExceptionIdentity
   * @throws Exception\Api
   * @throws Exception\Converter
   * @throws Exception\Helper
   * @throws SodiumException
   */
  public function create(?string $fragment = '#key'): Result {
    $this->uri->setFragment($fragment);
    // check DID exists
    if(($check = $this->checkIdIndexTangleExists())) {
      return $check;
    }
    //
    $authentication = new Authentication($this->uri, $this->keys->public);
    $document       = new Document($this->uri);
    $document->setAuthentication($authentication);
    // sign Document
    $signedDocument = $this->signDocument($document);
    // send Document to tangle
    $response = $this->sendToTangle($this->uri, $signedDocument);
    if($response instanceof ResponseError) {
      throw new ExceptionIdentity("Send to Tangle error '$response->message'");
    }
    //
    $result               = new Result();
    $result->uri          = $this->uri;
    $result->keys         = $this->keys;
    $result->explorerLink = $this->network->getExplorerUrlMessage($response->messageId);
    $result->messageId    = $response->messageId;
    $result->document     = $signedDocument;

    return $result;
  }

  /**
   * @param string|Document $document
   * @param string          $previousMessageId
   *
   * @return Result
   * @throws ExceptionIdentity
   * @throws Exception\Api
   * @throws Exception\Converter
   * @throws Exception\Helper
   * @throws SodiumException
   */
  public function manipulate(string|Document $document, string $previousMessageId, Service $service, Keys|array|string $serviceKeyInput): Result {
    if(is_string($document)) {
      $document = Document::fromJson($document);
    }
    // verify
    if(!self::verify($document->__toJSON())) {
      throw new ExceptionIdentity("Document sign error! Verify return 'false'");
    }
    // generate new Key
    $keys = new Keys($serviceKeyInput);
    // Uri
    $uri = Uri::parse($document->id . '#newKey');
    // add verificationMethod
    $authentication = new Authentication($uri, $keys->public);
    $document->setVerificationMethod($authentication);
    // add Service
    $document->setService($service);
    // set previousMessageId
    $document->setPreviousMessageId($previousMessageId);
    // sign Document
    $signedDocument = $this->signDocument($document);
    // send Document to tangle
    $response = $this->sendToTangle($uri, $signedDocument);
    if($response instanceof ResponseError) {
      throw new ExceptionIdentity("Send to Tangle error '$response->message'");
    }
    //
    $result               = new Result();
    $result->uri          = $uri;
    $result->keys         = $this->keys;
    $result->keysService  = $keys;
    $result->explorerLink = $this->network->getExplorerUrlMessage($response->messageId);
    $result->messageId    = $response->messageId;
    $result->document     = $signedDocument;

    return $result;
  }

  /**
   * @param Document $document
   *
   * @return Document
   * @throws ExceptionIdentity
   * @throws Exception\Converter
   * @throws Exception\Helper
   * @throws SodiumException
   */
  public function signDocument(Document $document): Document {
    // unset signatureValue
    unset($document->proof->signatureValue);
    // message to jcs
    $message = Converter::canonicalizeJSON($document->__toJSON());
    // sign message
    $signature = Ed25519::sign($this->keys->secret, $message);
    // set signatureValue
    $document->proof->signatureValue = Converter::base58_encode($signature);
    // verify
    if(!self::verify($document->__toJSON())) {
      throw new ExceptionIdentity("Document sign error! Verify return 'false'");
    }

    return $document;
  }

  /**
   * @param Uri      $uri
   * @param Document $document
   *
   * @return ResponseError|ResponseSubmitMessage
   * @throws Exception\Api
   * @throws Exception\Helper
   */
  private function sendToTangle(Uri $uri, Document $document): ResponseError|ResponseSubmitMessage {
    return (new sendMessage(new SingleNodeClient($this->network)))->index($uri->getId())
                                                                  ->data($document->__toJSON())
                                                                  ->run();
  }

  /**
   * @param string $json
   *
   * @return bool
   * @throws Exception\Converter
   * @throws SodiumException
   */
  static public function verify(string $json): bool {
    $array = json_decode($json, true);
    // check key proof
    if(!isset($array['proof']) || !isset($array['proof']['signatureValue'])) {
      return false;
    }
    // check key authentication
    if(!isset($array['authentication']) && count($array['authentication']) > 0) {
      return false;
    }
    // get publicKey
    $publicKey = Converter::base58_decode($array['authentication'][array_key_last($array['authentication'])]['publicKeyBase58']);
    // get signatureValue
    $signature = Converter::base58_decode($array['proof']['signatureValue']);
    // unset signatureValue
    unset($array['proof']['signatureValue']);
    $message = Converter::canonicalizeJSON($array);

    return Ed25519::verify_detached($signature, $message, $publicKey);
  }

  /**
   * @param string                    $messageId
   * @param string|array|Network|null $network
   *
   * @return bool
   * @throws ExceptionIdentity
   * @throws Exception\Api
   * @throws Exception\Converter
   * @throws Exception\Helper
   * @throws SodiumException
   */
  static public function verifyTangleMessage(string $messageId, string|array|Network|null $network = null): bool {
    $ret = (new getMessage(new SingleNodeClient($network)))->messageId($messageId)
                                                           ->run();
    if($ret instanceof ResponseError) {
      throw new ExceptionIdentity("Unknown messageId '$messageId'");
    }

    return self::verify($ret->payload->data);
  }
}