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
    return new \iota\schemas\response\Tips($this->_client->fetchArray("get","tips"));
  }
}