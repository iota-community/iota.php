<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseInfo
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseInfo extends AbstractApiResponse {
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
   * @var array
   */
  public array $features;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}