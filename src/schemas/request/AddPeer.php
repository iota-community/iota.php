<?php namespace iota\schemas\request;
/**
 * Class AddPeer
 *
 * @package iota\schemas\request
 */
class AddPeer extends \iota\schemas\request {
  /**
   * @var string
   */
  public string $multiAddress;
  /**
   * @var string
   */
  public string $alias;
}