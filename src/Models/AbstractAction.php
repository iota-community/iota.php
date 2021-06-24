<?php namespace IOTA\Models;

use IOTA\Client\SingleNodeClient;

/**
 * Class AbstractAction
 *
 * @package      IOTA\Action
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
abstract class AbstractAction {
  /**
   * @var AbstractApiResponse|null
   */
  public ?AbstractApiResponse $return = null;

  /**
   * AbstractAction constructor.
   *
   * @param SingleNodeClient $client
   * @param                  ...$args
   */
  public function __construct(protected SingleNodeClient $client, ...$args) {
    $this->return = call_user_func_array([
      $this,
      'exec',
    ], $args);
  }

  /**
   * @return AbstractApiResponse
   */
  abstract protected function exec(): AbstractApiResponse;

  /**
   * @return AbstractApiResponse|null
   */
  public function getReturn(): AbstractApiResponse|null {
    return $this->return;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return (string)$this->return;
  }
}