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

  /**
   * @param null $_array
   * @param null $_lKey
   *
   * @return array|string[]
   */
  public function serialize($_array = null, $_lKey = null) {
    $_buffer = [];
    // type
    $_buffer[] = \pack("L", $this->type);
    // index
    $_buffer[] = \pack("S", (\strlen($this->index) / 2));
    $_buffer[] = \hex2bin($this->index);
    // data
    $_buffer[] = \pack("L", (\strlen($this->data) / 2));
    $_buffer[] = \hex2bin($this->data);
    // payload len
    $_ret = \array_merge([\pack("L", \strlen(\implode('', $_buffer)))], $_buffer);

    return $_ret;
  }
}