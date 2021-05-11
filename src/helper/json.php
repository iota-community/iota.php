<?php namespace iota\helper;
/**
 * Class json
 *
 * @package iota\helper
 */
class json implements \ArrayAccess, \Iterator, \Countable, \Serializable {
  use \iota\system\php\iterator\iterator;
  use \iota\system\php\iterator\arrayaccess;
  use \iota\system\php\iterator\countable;
  use \iota\system\php\iterator\serializable;

  /**
   * @var bool
   */
  public $isJSON = false;

  /**
   * json constructor.
   *
   * @param string $str
   */
  public function __construct(public string|null $str) {
    if(!$this->str) {
      $this->str = '';
    }
    $this->_data = \json_decode($this->str, true) ?? [];
    $this->isJSON = \is_string($this->str) && \is_array($this->decode(true)) && (\json_last_error() == JSON_ERROR_NONE) ? true : false;
  }

  /**
   * @param bool|null $associative
   * @param int       $depth
   * @param int       $flags
   *
   * @return mixed
   */
  public function decode(?bool $associative = false, int $depth = 512, int $flags = 0) {
    return \json_decode($this->str, $associative, $depth, $flags);
  }

  /**
   * @return array
   */
  public function __toArray(): array {
    return $this->decode(true) ?? [];
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->str;
  }
}