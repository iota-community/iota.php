<?php namespace IOTA\Models;

use IOTA\Api\ResponseArray;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Helper\JSON;

/**
 * Class AbstractResponse
 *
 * @package      IOTA\Api
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
abstract class AbstractApiResponse extends AbstractApi {
  protected JSON $_input;

  /**
   * AbstractApiResponse constructor.
   *
   * @param mixed $value
   *
   * @throws ExceptionHelper
   */
  public function __construct(mixed $value) {
    $this->_input = JSON::create($value);
    $this->parse();
  }

  /**
   *
   */
  abstract protected function parse(): void;

  /**
   *
   */
  protected function defaultParse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}