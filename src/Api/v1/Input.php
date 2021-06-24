<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;
use IOTA\Models\InterfaceSerializer;
use IOTA\Models\TraitSerializer;

/**
 * Class Input
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Input extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * Input constructor.
   *
   * @param int    $type
   * @param string $transactionId
   * @param int    $transactionOutputIndex
   */
  public function __construct(public int $type, public string $transactionId, public int $transactionOutputIndex) {
  }

  /**
   * @return array
   */
  public function serialize(): array {
    return [
      self::serializeInt($this->type),
      self::serializeFixedHex($this->transactionId),
      self::serializeUInt16($this->transactionOutputIndex),
    ];
  }
}