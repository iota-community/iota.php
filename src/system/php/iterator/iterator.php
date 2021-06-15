<?php namespace iota\system\php\iterator;
/**
 * The Base class for Iterator.
 *
 * @package      iota\system\php\iterator
 */
trait iterator {
  /**
   * @var array
   */
  protected $_data = [];

  /**
   * Base constructor.
   *
   * @param $array
   */
  public function __construct($array) {
    if(\is_array($array)) {
      $this->_data = $array;
    }
  }

  /**
   *
   */
  public function rewind() {
    \reset($this->_data);
  }

  /**
   * @return mixed
   */
  public function current() {
    return \current($this->_data);
  }

  /**
   * @return int|string|null
   */
  public function key() {
    return \key($this->_data);
  }

  /**
   * @return mixed
   */
  public function next() {
    return \next($this->_data);
  }

  /**
   * @return bool
   */
  public function valid() {
    return $this->current() !== false;
  }
}