<?php namespace iota\schemas\unlockBlocks;
/**
 * Class unlockBlocks
 *
 * @package iota\schemas
 */
class Signature extends \iota\schemas {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var \iota\schemas\ed25519Signature
   */
  public \iota\schemas\ed25519Signature $signature;
}