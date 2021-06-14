<?php namespace iota\schemas;
/**
 * Class unlockBlocks
 *
 * @package iota\schemas
 */
class unlockBlocks extends \iota\schemas {
  /**
   *
   */
  const iota_unlockBlocks_type_0 = \iota\schemas\unlockBlocks\Signature::class;
  /**
   *
   */
  const iota_unlockBlocks_type_1 = \iota\schemas\unlockBlocks\Reference::class;
  /**
   * @var int
   */
  public int $type;
}