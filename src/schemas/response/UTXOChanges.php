<?php namespace iota\schemas\response;
/**
 * Class UTXOChanges
 *
 * @package iota\schemas\response
 */
class UTXOChanges extends \iota\schemas\response {
  /**
   * @var int
   */
  public int $index;
  /**
   * @var array
   */
  public array $createdOutputs;
  /**
   * @var array
   */
  public array $consumedOutputs;
}