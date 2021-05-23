<?php namespace iota\system\php\exception;
/**
 * The Base class provides a sourcl-specific exception class for try/catch blocks.
 *
 * @package iota\system\php\exception
 */
class base extends \Exception {
  /**
   * Construct the exception. Note: The message is NOT binary safe.
   *
   * @link  http://php.net/manual/en/exception.construct.php
   *
   * @param string    $message  [optional] The Exception message to throw.
   * @param int       $code     [optional] The Exception code.
   * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
   *
   * @since 5.1.0
   */
  public function __construct($message = "", $code = 0, \Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }

  /**
   * String representation of the exception
   *
   * @link  http://php.net/manual/en/exception.tostring.php
   * @return string the string representation of the exception.
   * @since 5.1.0
   */
  public function __toString() {
    return parent::__toString();
  }
}