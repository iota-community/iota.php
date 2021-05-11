<?php namespace iota\system\php\iterator;
/**
 * Trait countable
 *
 * @package      iota\system\php\iterator
 */
trait countable {
  /**
   * @return int
   */
  public function count() {
    return \count($this->_data);
  }
}