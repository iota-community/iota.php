<?php namespace IOTA\Models;

use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Helper\JSON;

/**
 * Class AbstractDid
 *
 * @package      IOTA\Models
 * @author       StefanBraun @tanglePHP
 * @copyright    Copyright (c) 2021, StefanBraun
 */
abstract class AbstractMap {
  /**
   * @return JSON
   * @throws ExceptionHelper
   */
  public function __toJSON(): JSON {
    return new JSON(json_encode($this));
  }

  /**
   * @return array
   * @throws ExceptionHelper
   */
  public function __toArray(): array {
    return ($this->__toJSON())->__toArray();
  }

  /**
   * @return string
   * @throws ExceptionHelper
   */
  public function __toString(): string {
    return (string)$this->__toJSON();
  }
}