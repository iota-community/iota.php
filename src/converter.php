<?php namespace iota;
/**
 * Class converter
 *
 * @package iota
 */
class converter {
  /**
   * Convert binary data into hexadecimal representation
   *
   * @param string $string <p>
   *                       A character.
   *                       </p>
   *
   * @return string the hexadecimal representation of the given string.
   */
  static public function strtohex(string $string): string {
    return \bin2hex($string);
  }

  /**
   * Convert hexadecimal string to its binary representation.
   * If the hexadecimal input string is of odd length or invalid hexadecimal string an <code>E_WARNING</code> level error is emitted.
   *
   * @param string $string Hexadecimal string to convert.
   *
   * @return string|false The binary representation of the given data or <b>FALSE</b> on failure.
   */
  static public function hextostr(string $string): string|false {
    return \hex2bin($string);
  }

  /**
   * Encodes data with MIME base64
   *
   * @param string $string <p>
   *                       The data to encode.
   *                       </p>
   *
   * @return string The encoded data, as a string.
   */
  static public function strtobase64(string $string): string {
    return \base64_encode($string);
  }

  /**
   * Decodes data encoded with MIME base64
   *
   * @param string $string <p>
   *                       The encoded data.
   *                       </p>
   * @param bool   $strict [optional] <p>
   *                       Returns false if input contains character from outside the base64
   *                       alphabet.
   *                       </p>
   *
   * @return string|false the original data or false on failure. The returned data may be
   * binary.
   */
  static public function base64tostr(string $string, bool $strict = false): string|false {
    return \base64_decode($string, $strict);
  }
}