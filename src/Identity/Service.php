<?php namespace IOTA\Identity;

use IOTA\Models\AbstractMap;

/**
 * Class Service
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Service extends AbstractMap {
  /**
   * @var string
   */
  public string $id;

  /**
   * Authentication constructor.
   *
   * @param Uri    $uri
   * @param string $publicKey
   */
  public function __construct(Uri $uri, public string $type = 'LinkedDomains', public string $serviceEndpoint = 'IOTA.php') {
    $this->id = $uri->getDid() . '#linked-domain';
  }
}