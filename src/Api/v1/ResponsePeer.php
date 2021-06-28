<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePeer
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponsePeer extends AbstractApiResponse {
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

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}