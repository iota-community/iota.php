<?php namespace iota\system\php\iterator;
/**
 * The Base class for Iterator.
 *
 * @package      iota\system\php\iterator
 */
class base implements \Iterator, \ArrayAccess, \Countable, \Serializable {
  /**
   * @var array
   */
  private $_var = [];
  /*---------------------------------------------------------------------------------------------------------
   * Iterator
   */
  /**
   * Base constructor.
   *
   * @param $array
   */
  public function __construct($array) {
    if(is_array($array)) {
      $this->_var = $array;
    }
  }

  /**
   *
   */
  public function rewind() {
    reset($this->_var);
  }

  /**
   * @return mixed
   */
  public function current() {
    return current($this->_var);
  }

  /**
   * @return int|string|null
   */
  public function key() {

    return key($this->_var);
  }

  /**
   * @return mixed
   */
  public function next() {
    return next($this->_var);
  }

  /**
   * @return bool
   */
  public function valid() {

    return $this->current() !== false;
  }

  /*---------------------------------------------------------------------------------------------------------
   * ArrayAccess
   */
  /**
   * @param mixed $offset
   * @param mixed $value
   */
  public function offsetSet($offset, $value) {
    if(is_null($offset)) {
      $this->_var[] = $value;
    }
    else {
      $this->_var[$offset] = $value;
    }
  }

  /**
   * @param mixed $offset
   *
   * @return bool
   */
  public function offsetExists($offset) {
    return isset($this->_var[$offset]);
  }

  /**
   * @param mixed $offset
   */
  public function offsetUnset($offset) {
    unset($this->_var[$offset]);
  }

  /**
   * @param mixed $offset
   *
   * @return mixed|null
   */
  public function offsetGet($offset) {
    return isset($this->_var[$offset]) ? $this->_var[$offset] : null;
  }
  /*---------------------------------------------------------------------------------------------------------
   * Countable
   */
  /**
   * @return int
   */
  public function count() {
    return \count($this->_var);
  }
  /*---------------------------------------------------------------------------------------------------------
 * Serializable
 */
  /**
   * @return string
   */
  public function serialize() {
    return \serialize($this->_var);
  }

  /**
   * @param string $serialized
   *
   * @return mixed
   */
  public function unserialize($serialized) {
    return \unserialize($serialized);
  }
}