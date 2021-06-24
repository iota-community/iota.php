<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponseTreasury
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponseTreasury extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $milestoneId;
  /**
   * @var int
   */
  public int $amount;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}