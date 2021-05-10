<?php namespace iota;
/**
 * Class schemas
 *
 * @package iota
 */
abstract class schemas {
  /**
   * schemas constructor.
   *
   * @param array $dat
   */
  public function __construct(array $dat = []) {
    foreach($dat as $key => $value) {
      $this->_parse($key, $value);
    }
  }

  /**
   * @param $key
   * @param $value
   */
  protected function _parse($key, $value): void {
    $this->{$key} = $value;
  }

  public function __toJSON() {
    return new \iota\helper\json(\json_encode($this));
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->__toJSON();
  }
}