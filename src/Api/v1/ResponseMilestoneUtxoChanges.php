<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseMilestoneUtxoChanges
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseMilestoneUtxoChanges extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $index;
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var int
   */
  public int $timestamp;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}