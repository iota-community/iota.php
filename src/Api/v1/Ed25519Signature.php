<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;

/**
 * Class Ed25519Signature
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Ed25519Signature extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 0;

  /**
   * Ed25519Signature constructor.
   *
   * @param string $publicKey
   * @param string $signature
   */
  public function __construct(public string $publicKey, public string $signature) {

  }
}