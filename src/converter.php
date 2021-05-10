<?php namespace iota;
/**
 * Class converter
 *
 * @package iota
 */
class converter {
  /**
   * @param string $str
   *
   * @return string
   */
  static public function strtohex(string $str) {
    return \bin2hex($str);
  }

  /**
   * @param string $hex
   *
   * @return string
   */
  static public function hextostr(string $hex) {
    return \hex2bin($hex);
  }
}