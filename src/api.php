<?php namespace iota;
/**
 * Class api
 *
 * @package iota
 */
abstract class api {
  public function __construct(protected \iota\client $_client) {
  }
}