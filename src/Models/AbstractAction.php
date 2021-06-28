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
   * @var AbstractApiResponse
   */
  public mixed $result = null;
  /**
   * @var string|array|null
   */
  protected string|array|null $callback = null;

  /**
   * MessageSend constructor.
   *
   * @param SingleNodeClient $client
   */
  public function __construct(protected SingleNodeClient $client) {
  }

  /**
   * @return AbstractApiResponse
   */
  abstract public function run(): mixed;

  /**
   * @param $returnValue
   */
  protected function callCallback($returnValue): void {
    if(isset($this->callback)) {
      call_user_func_array($this->callback, [
        $this->result,
        $returnValue,
        $this,
      ]);
    }
  }

  /**
   * @param string $callback
   *
   * @return $this
   */
  public function callback(string $callback): self {
    $this->callback = $callback;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getResult(): mixed {
    if($this->result === null) {
      $this->run();
    }

    return $this->result;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return (string)$this->getResult();
  }
}