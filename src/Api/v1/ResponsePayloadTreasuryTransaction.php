<?php namespace IOTA\Api\v1;

use IOTA\Models\AbstractApiResponse;

/**
 * Class ResponsePayloadMilestone
 *
 * @package      IOTA\Api\v1
 * @author       StefanBraun @tanglePHP
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ResponsePayloadTreasuryTransaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 4;
  /**
   * @var array
   */
  public array $input;
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