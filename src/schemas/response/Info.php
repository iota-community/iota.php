<?php namespace iota\schemas\response;
/**
 * Class Info
 *
 * @package iota\schemas\response
 */
class Info extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $name;
  /**
   * @var string
   */
  public string $version;
  /**
   * @var bool
   */
  public bool $isHealthy;
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var string
   */
  public string $bech32HRP;
  /**
   * @var float
   */
  public float $minPoWScore;
  /**
   * @var float
   */
  public float $messagesPerSecond;
  /**
   * @var float
   */
  public float $referencedMessagesPerSecond;
  /**
   * @var float
   */
  public float $referencedRate;
  /**
   * @var int
   */
  public int $latestMilestoneTimestamp;
  /**
   * @var int
   */
  public int $latestMilestoneIndex;
  /**
   * @var int
   */
  public int $confirmedMilestoneIndex;
  /**
   * @var int
   */
  public int $pruningIndex;
  /**
   * @var string
   */
  public array $features;
}