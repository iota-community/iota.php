<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;
use IOTA\Models\InterfaceSerializer;
use IOTA\Models\TraitSerializer;

/**
 * Class Address
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Address extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * Address constructor.
   *
   * @param int    $type
   * @param string $address
   */
  public function __construct(public int $type, public string $address) {
  }

  /**
   * @return array
   */
  public function serialize(): array {
    return [
      self::serializeInt($this->type),
      self::serializeFixedHex($this->address),
    ];
  }
}