<?php namespace IOTA\Helper;

use IOTA\Exception\Helper as ExceptionHelper;

/**
 * Class Json
 *
 * @package      IOTA\Helper
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class JSON {
  /**
   * JSON constructor.
   *
   * @param string $string
   *
   * @throws ExceptionHelper
   */
  public function __construct(protected string $string) {
    if(!Converter::isJSON($this->string)) {
      throw new ExceptionHelper("String have to be in JSON format");
    }
  }

  /**
   * @param mixed $value
   * @param int   $flags
   * @param int   $depth
   *
   * @return JSON
   * @throws ExceptionHelper
   */
  static public function create(mixed $value, int $flags = 0, int $depth = 512): JSON {
    if($value instanceof JSON) {
      return $value;
    }
    if(is_string($value) && Converter::isJSON($value)) {
      return new JSON($value);
    }
    if(is_string($value)) {
      return new JSON('{"JSON":"' . $value . '"}');
    }

    return new JSON(json_encode($value, $flags, $depth));
  }

  /**
   * @param bool|null $associative
   * @param int       $depth
   * @param int       $flags
   *
   * @return mixed
   */
  public function decode(?bool $associative = false, int $depth = 512, int $flags = 0): mixed {
    return json_decode($this->string, $associative, $depth, $flags);
  }

  /**
   * @return array
   */
  public function __toArray(): array {
    return $this->decode(true) ?? [];
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->string;
  }
}