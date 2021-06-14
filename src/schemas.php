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
    if(!isset($value[$_index])) {


      return $value;
    }
    $_className = "\\iota\\schemas\\{$className}";
    if(\defined("{$_className}::iota_{$className}_{$_index}_{$value[$_index]}")) {
      $_r = \constant("{$_className}::iota_{$className}_{$_index}_{$value[$_index]}");

      return new $_r($value);
    }

    return $value;
  }

  /**
   * @return helper\json
   */
  public function __toJSON(): \iota\helper\json {
    return new \iota\helper\json(\json_encode($this));
    //return new \iota\helper\json(\json_encode($this, JSON_FORCE_OBJECT));
  }

  /**
   * @return array
   */
  public function __toArray(): array {
    return ($this->__toJSON())->__toArray();
  }

  /**
   * @param null $_array
   *
   * @return array
   * @throws \Exception
   */
  public function serialize($_array = null) {
    $_ret   = [];
    $_array = $_array ?? $this;
    foreach($_array as $_key => $_prop) {
      if(\is_object($_prop)) {
        $_ret = \array_merge($_ret, $_prop->serialize());
      }
      elseif(\is_array($_prop)) {
        if($_key == 'inputs' || $_key == 'outputs') {
          $_ret[] = \pack("S", \count($_prop));
        }
        $_ret = \array_merge($_ret, $this->serialize($_prop));
      }
      else {
        switch($_key) {
          // int (byte)
          case 'type' :
            $_ret[] = \pack("C", $_prop);
            break;
          // UInt16
          case 'transactionOutputIndex' :
            $_ret[] = \pack("S", $_prop);
            break;
          // UInt64
          case 'amount' :
            // parse to BigINT
            $_ret[] = \pack("P", $_prop);
            break;
          // FixedHex
          case 'address':
          case 'transactionId':
            $_ret[] = \hex2bin($_prop);
            break;
          default:
            throw new \Exception("Unknown key '{$_key}' to serialize");
        }
      }
    }

    return $_ret;
  }

  /**
   * @return string
   * @throws \Exception
   */
  public function __toHash() {
    $_ret = \implode('', $this->serialize());
    $_ret = \str_pad(\iota\converter::bin2hex($_ret), 256, '0');
    $_ret = \iota\converter::bin2hex(\iota\hash::blake2b_sum256(\iota\converter::hex2bin($_ret)));

    return $_ret;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->__toJSON();
  }
}