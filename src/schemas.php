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
   * @param string $key
   * @param mixed  $value
   */
  protected function _parse(string $key, mixed $value): void {
    $_className   = "\\iota\\schemas\\{$key}";
    $this->{$key} = \class_exists($_className) ? $this->_parse_init($key, $value, 'type') : $value;
  }

  /**
   * @param        $className
   * @param        $value
   * @param string $_index
   *
   * @return mixed
   */
  protected function _parse_init($className, $value, string $_index = 'type'): mixed {
    $_className = "\\iota\\schemas\\{$className}";
    if($_ret = \constant("{$_className}::iota_{$className}_{$_index}_{$value[$_index]}")) {
      return new $_ret($value);
    }

    return $value;
  }

  /**
   * @return helper\json
   */
  public function __toJSON(): \iota\helper\json {
    return new \iota\helper\json(\json_encode($this));
  }

  /**
   * @return array
   */
  public function __toArray(): array {
    return ($this->__toJSON())->__toArray();
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->__toJSON();
  }
}