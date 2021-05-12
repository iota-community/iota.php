<?php namespace iota\api;
/**
 * Class tangle
 *
 * @package      iota\api
 */
class tangle extends \iota\api {
  /**
   * Returns tips that are ideal for attaching a message. The tips can be considered as non-lazy and are therefore ideal for attaching a message.
   *
   * @return \iota\schemas\response\Tips
   */
  public function tips(): \iota\schemas\response\Tips {
    return $this->fetch([
      'route'  => "tips",
      'return' => \iota\schemas\response\Tips::class,
    ]);
  }
}