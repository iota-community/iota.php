<?php namespace IOTA\Identity;

/**
 * Class Uri
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Uri {
  /**
   * @var string
   */
  static protected string $scheme = 'did';
  /**
   * @var string
   */
  static protected string $delimiterPath = '/';
  /**
   * @var string
   */
  static protected string $delimiterFragment = '#';

  /**
   * Uri constructor.
   *
   * @param string      $method
   * @param string      $id
   * @param string|null $path
   * @param string|null $fragment
   */
  public function __construct(protected string $method, protected string $id, protected ?string $path = null, protected ?string $fragment = null) {
    // normalize path
    if(!empty($this->path) && is_string($this->path) && $this->path !== self::$delimiterPath) {
      // Check path beginns with delimiterPath
      if(substr($this->path, 0, 1) != self::$delimiterPath) {
        $this->path = self::$delimiterPath . $this->path;
      }
      // set delimiter to end
      $this->path = rtrim($this->path, self::$delimiterPath);
    }
    // normalize fragment
    if(!empty($this->fragment) && is_string($this->fragment) && $this->fragment !== self::$delimiterFragment) {
      // set delimiter to end
      $this->fragment = ltrim($this->fragment, self::$delimiterFragment);
    }
  }

  /**
   * @param string $uri
   *
   * @return Uri
   */
  static public function parse(string $uri): Uri {
    $m = explode(":", $uri);
    array_shift($m); // scheme
    $id       = array_pop($m);
    $method   = implode(":", $m);
    $fragment = null;
    $path     = null;
    //
    if($pos = strpos($id, self::$delimiterFragment)) {
      $fragment = substr($id, $pos);
      $id       = substr($id, 0, $pos);
    }
    if($pos = strpos($id, self::$delimiterPath)) {
      $path = substr($id, $pos);
      $id   = substr($id, 0, $pos);
    }

    return new Uri($method, $id, $path, $fragment);
  }

  /**
   * @return string
   */
  public function getDid(): string {
    return self::$scheme . ":" . $this->method . ":" . $this->id;
  }

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getPath(): string {
    return $this->path ?? '';
  }

  /**
   * @return string
   */
  public function getFragment(): string {
    return isset($this->fragment) ? (self::$delimiterFragment . $this->fragment) : '';
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->getDid() . $this->getPath() . $this->getFragment();
  }
}