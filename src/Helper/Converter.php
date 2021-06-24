<?php namespace IOTA\Helper;

use IOTA\Crypto\Bech32;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Exception\Converter as ExceptionConverter;

/**
 * Class Converter
 *
 * @package      iota\Helper
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Converter {
  /**
   * @param string $val
   *
   * @return string
   */
  static public function string2Hex(string $val): string {
    return bin2hex($val);
  }

  /**
   * @param string $val
   *
   * @return string|false
   * @throws ExceptionConverter
   */
  static public function hex2String(string $val): string|false {
    if(!self::isHex($val)) {
      throw new ExceptionConverter("Input string must be hexadecimal string");
    }

    return hex2bin($val);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function bits2Hex(string $val): string {
    $_hex = "";
    foreach(str_split($val, 4) as $_chunk) {
      $_hex .= base_convert($_chunk, 2, 16);
    }

    return $_hex;
  }

  /**
   * @param string $val
   *
   * @return string
   * @throws ExceptionConverter
   */
  static public function hex2Bits(string $val): string {
    if(!self::isHex($val)) {
      throw new ExceptionConverter("Input string must be hexadecimal string");
    }
    $_bits = "";
    for($i = 0; $i < strlen($val); $i++) {
      $_bits .= str_pad(base_convert($val[$i], 16, 2), 4, '0', STR_PAD_LEFT);
    }

    return $_bits;
  }

  /**
   * @param string $val
   *
   * @return array
   * @throws ExceptionConverter
   */
  static public function hex2ByteArray(string $val): array {
    if(!self::isHex($val)) {
      throw new ExceptionConverter("Input string must be hexadecimal string");
    }
    $_bin = hex2bin($val);

    return unpack('C*', $_bin);
  }

  /**
   * @param array $data
   *
   * @return string
   */
  static public function byteArray2Hex(array $data): string {
    $_chars = array_map("chr", $data);
    $_bin   = join($_chars);

    return bin2hex($_bin);
  }

  /**
   * @param string $val
   *
   * @return array
   */
  static function string2ByteArray(string $val): array {
    return unpack('C*', $val);
  }

  /**
   * @param array $data
   *
   * @return string
   */
  static function byteArray2String(array $data): string {
    $_chars = array_map("chr", $data);

    return join($_chars);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function base64_encode(string $val): string {
    return base64_encode($val);
  }

  /**
   * @param string $val
   * @param bool   $strict
   *
   * @return string|false
   */
  static public function base64_decode(string $val, bool $strict = false): string|false {
    return base64_decode($val, $strict);
  }

  /**
   * @param array $data
   * @param int   $inLen
   * @param int   $fromBits
   * @param int   $toBits
   * @param bool  $_pad
   *
   * @return array
   * @throws ExceptionConverter
   */
  static public function bits(array $data, int $inLen, int $fromBits, int $toBits, bool $_pad = true): array {
    $_acc    = 0;
    $_bits   = 0;
    $_ret    = [];
    $_maxv   = (1 << $toBits) - 1;
    $_maxacc = (1 << ($fromBits + $toBits - 1)) - 1;
    for($_i = 0; $_i < $inLen; $_i++) {
      $_value = $data[$_i];
      if($_value < 0 || $_value >> $fromBits) {
        throw new ExceptionConverter('Invalid value for convert bits');
      }
      $_acc  = (($_acc << $fromBits) | $_value) & $_maxacc;
      $_bits += $fromBits;
      while($_bits >= $toBits) {
        $_bits  -= $toBits;
        $_ret[] = (($_acc >> $_bits) & $_maxv);
      }
    }
    if($_pad) {
      if($_bits) {
        $_ret[] = ($_acc << $toBits - $_bits) & $_maxv;
      }
    }
    else if($_bits >= $fromBits || ((($_acc << ($toBits - $_bits))) & $_maxv)) {
      throw new ExceptionConverter('Invalid data');
    }

    return $_ret;
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isHex(mixed $val): bool {
    return is_string($val) && preg_match('/^[a-z0-9+\/]+={0,2}$/i', $val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isNumeric(mixed $val): bool {
    return is_numeric($val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  public static function isUtf8(mixed $val): bool {
    return is_string($val) && strlen($val) !== mb_strlen($val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isBitwise(mixed $val): bool {
    return is_string($val) && preg_match('/^[01]+$/', $val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isBase64(mixed $val): bool {
    return is_string($val) && preg_match('/^[a-z0-9+\/]+={0,2}$/i', $val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isBase16(mixed $val): bool {
    return is_string($val) && preg_match('/^(0x)?[a-f0-9]+$/i', $val);
  }

  /**
   * @param string $string
   *
   * @return bool
   */
  static public function isJSON(string $string): bool {
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
  }

  /**
   * @param string $string
   *
   * @return bool
   */
  static public function isBinary(string $string): bool {
    return preg_match('~[^\x20-\x7E\t\r\n]~', $string) > 0;
  }

  /**
   * @param $addressEd25519
   * @param $hrp
   *
   * @return string
   * @throws ExceptionConverter
   */
  static public function ed25519ToBech32($addressEd25519, $hrp): string {
    $data = self::hex2byteArray($addressEd25519);
    array_unshift($data, 0);

    return Bech32::encode($hrp, self::bits($data, count($data), 8, 5));
  }

  /**
   * @param $addressBech32
   *
   * @return string
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   */
  static public function bech32ToEd25519($addressBech32): string {
    $data = Bech32::decode($addressBech32)[1];

    return substr(self::byteArray2Hex(self::bits($data, count($data), 5, 8, false)), 2);
  }
}