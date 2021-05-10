<?php namespace iota\schemas\payload;
/**
 * Class Indexation
 *
 * @package iota\schemas\payload
 */
class Indexation extends \iota\schemas\payload {
  /**
   * @var int
   */
  public int $type = 2;
  /**
   * @var string
   */
  public string $index = '';
  /**
   * @var string
   */
  public string $data = '';
}