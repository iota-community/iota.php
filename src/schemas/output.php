<?php namespace iota\schemas;
/**
 * Class output
 *
 * @package iota\schemas
 */
abstract class output extends \iota\schemas {
  public int $type;
  public array $address;
  public int $amount;
}