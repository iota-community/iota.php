<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApi;

/**
 * Class PayloadTransaction
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class PayloadTransaction extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 0;

  /**
   * PayloadTransaction constructor.
   *
   * @param EssenceTransaction $essence
   * @param array              $unlockBlocks
   */
  public function __construct(public EssenceTransaction $essence, public array $unlockBlocks = []) {
  }

  /**
   * @param $block
   */
  public function unlockBlocks($block) {
    $this->unlockBlocks[] = $block;
  }

}