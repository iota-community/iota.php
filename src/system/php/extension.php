<?php namespace iota\system\php;
/**
 * Class extension
 *
 * @package iota\system\php
 */
abstract class extension {
  /**
   * @param $varname
   * @param $value
   *
   * @return $this
   */
  static public function loaded($extension) {
    return \extension_loaded($extension);
  }

  /**
   * @param $varname
   *
   * @return string
   */
  static public function getLoaded() {
    return \get_loaded_extensions();
  }
}