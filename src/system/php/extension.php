<?php namespace iota\system\php;
/**
 * Class extension
 *
 * @package iota\system\php
 */
abstract class extension {
  /**
   * @param $extension
   *
   * @return $this
   */
  static public function loaded($extension) {
    return \extension_loaded($extension);
  }

  /**
   * @return string
*/
  static public function getLoaded() {
    return \get_loaded_extensions();
  }
}