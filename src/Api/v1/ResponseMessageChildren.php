<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseMessageChildren
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseMessageChildren extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var int
   */
  public int $maxResults;
  /**
   * @var int
   */
  public int $count;
  /**
   * @var array
   */
  public array $childrenMessageIds;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}