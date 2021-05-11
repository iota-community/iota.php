<?php namespace iota\schemas\response;
/**
 * Class Info
 *
 * @package iota\schemas\response
 */
class Error extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $code;
  /**
   * @var string
   */
  public string $message;
}