<?php namespace iota\schemas;
/**
 * Class response
 *
 * @package iota\schemas
 */
abstract class response extends \iota\schemas {
  /**
   * response constructor.
   *
   * @param array $dat
   */
  public function __construct(array $dat = []) {
    parent::__construct($dat['data'] ?? $dat);
  }
}