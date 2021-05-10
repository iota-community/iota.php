<?php namespace iota\schemas\response;
/**
 * Class Message
 *
 * @package iota\schemas\response
 */
class Message extends \iota\schemas\response {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var \iota\schemas\payload
   */
  public \iota\schemas\payload $payload;
  /**
   * @var string
   */
  public string $nonce;

  /**
   * @param $key
   * @param $value
   */
  protected function _parse($key, $value): void {
    if($key == 'payload') {
      $this->payload = new \iota\schemas\payload\Indexation($value);

      return;
    }
    parent::_parse($key, $value);
  }
}