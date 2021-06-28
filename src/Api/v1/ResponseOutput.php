<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseOutput
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseOutput extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var string
   */
  public string $transactionId;
  /**
   * @var int
   */
  public int $outputIndex;
  /**
   * @var bool
   */
  public bool $isSpent;
  /**
   * @var array
   */
  public array $output;

    /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}