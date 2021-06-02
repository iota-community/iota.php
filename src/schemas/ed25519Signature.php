<?php namespace iota\schemas;
/**
 * Class ed25519Signature
 *
 * @package iota\schemas
 */
class ed25519Signature extends \iota\schemas {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var string
   */
  public string $publicKey;
  /**
   * @var string
   */
  public string $signature;
}