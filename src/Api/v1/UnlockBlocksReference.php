<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;

/**
 * Class UnlockBlocksReference
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class UnlockBlocksReference extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 1;

  /**
   * UnlockBlocksReference constructor.
   *
   * @param int $reference
   */
  public function __construct(public int $reference) {

  }
}