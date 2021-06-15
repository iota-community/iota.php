<?php namespace iota\system\php;
/**
 * Class config
 *
 * @package scl\core\system\php
 */
abstract class config {
  /**
   * @param $varname
   * @param $value
   *
   * @return false|string
   */
  static public function set($varname, $value) {
    return \ini_set($varname, $value);
  }

  /**
   * @param $varname
   *
   * @return string
   */
  static public function get($varname) {
    $_switch = \strtolower($varname);
    switch($_switch) {
      case 'os':
        return PHP_OS;
      case 'uname':
      case 'uname_a':
      case 'uname_s':
      case 'uname_n':
      case 'uname_v':
      case 'uname_m':
        return \php_uname(\substr($_switch, -2) == "_" ? \substr($_switch, -1) : null);
      case 'sapi':
        return PHP_SAPI;
      case 'sapi_name':
        return \php_sapi_name();
      case 'version':
        return PHP_VERSION;
      case 'version_id':
        return PHP_VERSION_ID;
      case 'major_version':
        return PHP_MAJOR_VERSION;
      case 'minor_version':
        return PHP_MINOR_VERSION;
      case 'release_version':
        return PHP_RELEASE_VERSION;
    }

    return \ini_get($varname);
  }
}