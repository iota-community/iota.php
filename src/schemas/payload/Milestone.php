<?php namespace iota\schemas\payload;
/**
 * Class Transaction
 *
 * @package iota\schemas\payload
 */
class Milestone extends \iota\schemas\payload {
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
}