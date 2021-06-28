<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;
use IOTA\Models\InterfaceSerializer;
use IOTA\Models\TraitSerializer;

/**
 * Class Output
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Output extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * Output constructor.
   *
   * @param int     $type
   * @param Address $address
   * @param int     $amount
   */
  public function __construct(public int $type, public Address $address, public int $amount) {
  }

  /**
   * @return array
   */
  public function serialize(): array {
    $_ret   = [self::serializeInt($this->type)];
    $_ret   = array_merge($_ret, $this->address->serialize());
    $_ret[] = self::serializeBigInt($this->amount);

    return $_ret;
  }
}