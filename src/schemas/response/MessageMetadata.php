<?php namespace iota\schemas\response;
/**
 * Class MessageMetadata
 *
 * @package iota\schemas\response
 */
class MessageMetadata extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var array
   */
  public array $parentMessageIds;
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
}