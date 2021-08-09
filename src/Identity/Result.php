<?php namespace IOTA\Identity;
/**
 * Class Result
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Result {
  /**
   * @var Document|null
   */
  public ?Document $document;
  /**
   * @var Uri|null
   */
  public ?Uri $uri;
  /**
   * @var string|null
   */
  public ?string $explorerLink;
  /**
   * @var string|null
   */
  public ?string $messageId;
  /**
   * @var array|null
   */
  public ?array $keys;
}