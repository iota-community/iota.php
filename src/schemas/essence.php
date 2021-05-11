<?php namespace iota\schemas;
/**
 * Class essence
 *
 * @package iota\schemas
 */
abstract class essence extends \iota\schemas {
  /**
   *
   */
  const iota_essence_type_0 = \iota\schemas\essence\Transaction::class;
  /**
   * @var int
   */
  public int $type;
}