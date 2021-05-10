<?php namespace iota\schemas;
/**
 * Class response
 *
 * @package iota\schemas
 */
abstract class response extends \iota\schemas {
  public function __construct(array $dat = []) {
    foreach($dat['data'] as $key => $value) {
      $this->_parse($key, $value);
    }
  }
}