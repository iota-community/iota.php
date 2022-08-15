<?php namespace IOTA\Api\v1;

use Exception;
use IOTA\Models\AbstractApi;
use IOTA\Models\InterfaceSerializer;
use IOTA\Models\TraitSerializer;

/**
 * Class EssenceTransaction
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class EssenceTransaction extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var PayloadIndexation
   */
  public PayloadIndexation $payload;

  /**
   * @return array
   * @throws Exception
   */
  public function serialize(): array {
    /**
     * @var Input|Output $object
     */
    $_ret = [self::serializeInt($this->type)];
    // inputs
    $_ret[] = self::serializeUInt16(count($this->inputs));
    foreach($this->inputs as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }
    // outputs
    $_ret[] = self::serializeUInt16(count($this->outputs));
    foreach($this->outputs as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }
    // payload
    if(isset($this->payload)) {
      $_ret = array_merge($_ret, $this->payload->serialize());
    }
    else {
      $_ret[] = pack("L", 0);
    }

    return $_ret;
  }
}