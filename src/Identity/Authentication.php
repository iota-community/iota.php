<?php namespace IOTA\Identity;

use IOTA\Helper\Converter;
use IOTA\Models\AbstractMap;

/**
 * Class Authentication
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Authentication extends AbstractMap {
  /**
   * @var string
   */
  public string $id;
  /**
   * @var string
   */
  public string $controller;
  /**
   * @var string
   */
  public string $type = 'Ed25519VerificationKey2018';
  /**
   * @var string
   */
  public string $publicKeyBase58;

  /**
   * Authentication constructor.
   *
   * @param Uri    $uri
   * @param string $publicKey
   */
  public function __construct(Uri $uri, string $publicKey) {
    $this->id         = $uri;
    $this->controller = $uri->getDid();
    //
    $publicKey = Converter::isHex($publicKey) ? Converter::hex2String($publicKey) : $publicKey;
    //
    $this->publicKeyBase58 = Converter::base58_encode($publicKey);
  }
}