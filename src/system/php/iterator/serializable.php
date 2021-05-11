<?php namespace iota\system\php\iterator;
/**
 * The Base class for Iterator.
 *
 * @package      scl\core\system\php\iterator
 */
trait serializable {
  /**
   * @return string
   */
  public function serialize() {
    return \serialize($this->_data);
  }

  /**
   * @param string $serialized
   *
   * @return mixed
   */
  public function unserialize($serialized, array $options = null) {
    if(!\is_null($options)) {
      return $this->_data = \unserialize($serialized, $options);
    }
    return $this->_data = \unserialize($serialized);
  }
}