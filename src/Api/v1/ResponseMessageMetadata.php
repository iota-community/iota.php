<?php namespace IOTA\Api\v1;

use IOTA\Api\ResponseArray;
use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseMessageMetadata
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseMessageMetadata extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var array
   */
  public ResponseArray $parentMessageIds;
  /**
   * @var bool
   */
  public bool $isSolid;
  /**
   * @var int
   */
  public int $referencedByMilestoneIndex;
  /**
   * @var int
   */
  public int $milestoneIndex;
  /**
   * @var string
   */
  public string $ledgerInclusionState;
  /**
   * @var int
   */
  public int $conflictReason;
  /**
   * @var bool
   */
  public bool $shouldPromote;
  /**
   * @var bool
   */
  public bool $shouldReattach;

    /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}