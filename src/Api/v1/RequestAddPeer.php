<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiRequest;

/**
 * Class RequestAddPeer
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class RequestAddPeer extends AbstractApiRequest {
  /**
   * RequestPeer constructor.
   *
   * @param string      $multiAddress
   * @param string|null $alias
   */
  public function __construct(public string $multiAddress, public ?string $alias = null) {
  }
}