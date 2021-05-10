<?php namespace iota\schemas\response;
/**
 * Class Peer
 *
 * @package iota\schemas\response
 */
class Peer extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $id;
  /**
   * @var array
   */
  public array $multiAddresses;
  /**
   * @var string
   */
  public string $alias;
  /**
   * @var string
   */
  public string $relation;
  /**
   * @var bool
   */
  public bool $connected;
  /**
   * @var array
   */
  public array $gossip;
}