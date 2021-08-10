<?php namespace IOTA\Identity;

use IOTA\Helper\Converter;
use IOTA\Helper\JSON;
use IOTA\Identity;
use IOTA\Models\AbstractMap;
use IOTA\Exception\Identity as ExceptionIdentity;

/**
 * Class Document
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Document extends AbstractMap {
  /**
   * @var string|Uri
   */
  public string $id;
  /**
   * @var array
   */
  public array $verificationMethod;
  /**
   * @var array
   */
  public array $authentication;
  /**
   * @var array
   */
  public array $service;
  /**
   * @var string
   */
  public string $created;
  /**
   * @var string
   */
  public string $updated;
  /**
   * @var string
   */
  public string $previousMessageId;
  /**
   * @var Proof
   */
  public Proof $proof;

  /**
   * Document constructor.
   *
   * @param Uri                 $uri
   * @param Authentication|null $authentication
   */
  public function __construct(Uri $uri, ?Authentication $authentication = null) {
    $this->id = $uri->getDid();
    if($authentication) {
      $this->setAuthentication($authentication);
    }
    $this->setCreated();
    $this->setUpdated();
    $this->proof = new Proof();
  }

  /**
   * @param string|JSON $json
   *
   * @return Document
   * @throws \IOTA\Exception\Helper
   */
  static public function fromJson(string|JSON $json): Document {
    $json = new JSON($json);

    return self::fromArray($json->__toArray());
  }

  /**
   * @param array $array
   *
   * @return Document
   * @throws ExceptionIdentity
   * @throws \IOTA\Exception\Converter
   */
  static public function fromArray(array $array): Document {
    if(!isset($array['id'])) {
      throw new ExceptionIdentity('Empty id');
    }
    if(!isset($array['created'])) {
      throw new ExceptionIdentity('Empty created');
    }
    if(!isset($array['updated'])) {
      throw new ExceptionIdentity('Empty updated');
    }
    if(!isset($array['authentication']) && count($array['authentication']) > 0) {
      throw new ExceptionIdentity('Empty authentication');
    }
    //
    $uri       = Uri::parse($array['authentication'][array_key_last($array['authentication'])]['id']);
    $publicKey = Converter::base58_decode($array['authentication'][array_key_last($array['authentication'])]['publicKeyBase58']);
    //
    $authentication    = new Authentication($uri, $publicKey);
    $authentication->controller = $array['authentication'][array_key_last($array['authentication'])]['controller'];
    $authentication->type = $array['authentication'][array_key_last($array['authentication'])]['type'];
    //

    $document          = new Document(Uri::parse($array['id']), $authentication);
    $document->created = $array['created'];
    $document->updated = $array['updated'];
    //
    if(isset($array['proof'])) {
      $document->proof                     = new Proof();
      $document->proof->type               = $array['proof']['type'];
      $document->proof->verificationMethod = $array['proof']['verificationMethod'];
      $document->proof->signatureValue     = $array['proof']['signatureValue'];
    }

    return $document;
  }

  /**
   * @param Authentication $authentication
   *
   * @return $this
   */
  public function setAuthentication(Authentication $authentication): self {
    $this->authentication = [$authentication];

    return $this;
  }

  /**
   * @param Service $service
   *
   * @return $this
   */
  public function setService(Service $service): self {
    $this->service = [$service];

    return $this;
  }

  /**
   * @param Authentication $authentication
   *
   * @return $this
   */
  public function setVerificationMethod(Authentication $authentication): self {
    $this->verificationMethod = [$authentication];

    return $this;
  }

  /**
   * @param string $messageId
   *
   * @return $this
   */
  public function setPreviousMessageId(string $messageId): self {
    $this->previousMessageId = $messageId;

    return $this;
  }

  /**
   * @return $this
   */
  public function setCreated(): self {
    $this->created = date('Y-m-d\TH:i:s\Z', time());

    return $this;
  }

  /**
   * @return $this
   */
  public function setUpdated(): self {
    $this->updated = date('Y-m-d\TH:i:s\Z', time());

    return $this;
  }

  /**
   * @return bool
   * @throws \IOTA\Exception\Converter
   * @throws \IOTA\Exception\Helper
   * @throws \SodiumException
   */
  public function verify() {
    return Identity::verify($this->__toJSON());
  }
}