<?php namespace iota\system\php\iterator;
/**
 * Trait arrayaccess
 *
 * @package      iota\system\php\iterator
 */
trait arrayaccess {
  /*---------------------------------------------------------------------------------------------------------
   * ArrayAccess
   */
  /**
   * @param mixed $offset
   * @param mixed $value
   */
  public function offsetSet($offset, $value) {
    if(\is_null($offset)) {
      $this->_data[] = $value;
    }
    else {
      $this->_data[$offset] = $value;
    }
  }

  /**
   * @param mixed $offset
   *
   * @return bool
   */
  public function offsetExists($offset) {
    return isset($this->_data[$offset]);
  }

  /**
   * @param mixed $offset
   */
  public function offsetUnset($offset) {
    unset($this->_data[$offset]);
  }

  /**
   * @param mixed $offset
   *
   * @return mixed|null
   */
  public function offsetGet($offset) {
    return $this->_data[$offset] ?? null;
  }
}