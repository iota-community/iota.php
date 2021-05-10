<?php namespace iota\helper;
/**
 * Class json
 *
 * @package iota\helper
 */
class json {
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
    $this->isJSON = \is_string($str) && \is_array(\json_decode($str, true)) && (\json_last_error() == JSON_ERROR_NONE) ? true : false;
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