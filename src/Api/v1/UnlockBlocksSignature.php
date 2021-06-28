<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;

/**
 * Class UnlockBlocksSignature
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class UnlockBlocksSignature extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 0;

  /**
   * UnlockBlocks constructor.
   *
   * @param Ed25519Signature $signature
   */
  public function __construct(public Ed25519Signature $signature) {

  }
}