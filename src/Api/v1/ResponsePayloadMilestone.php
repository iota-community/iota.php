<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePayloadMilestone
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponsePayloadMilestone extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 1;
  /**
   * @var int
   */
  public int $index;
  /**
   * @var int
   */
  public int $timestamp;
  /**
   * @var array
   */
  public array $parents;
  /**
   * @var string
   */
  public string $inclusionMerkleProof;
  /**
   * @var string
   */
  public string $nextPoWScore;
  /**
   * @var string
   */
  public string $nextPoWScoreMilestoneIndex;
  /**
   * @var array
   */
  public array $publicKeys;
  /**
   * @var array
   */
  public array $signatures;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}