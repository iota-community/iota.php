<?php namespace IOTA\Identity;
/**
 * Class Uri
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @tanglePHP
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
   * @var string|null
   */
  protected ?string $fragment = null;

  /**
   * Uri constructor.
   *
   * @param string      $method
   * @param string      $id
   * @param string|null $path
   * @param string|null $fragment
   */
  public function __construct(protected string $method, protected string $id, protected ?string $path = null, ?string $fragment = null) {
    // normalize path
    if(!empty($this->path) && is_string($this->path) && $this->path !== self::$delimiterPath) {
      // Check path beginns with delimiterPath
      if(substr($this->path, 0, 1) != self::$delimiterPath) {
        $this->path = self::$delimiterPath . $this->path;
      }
      // set delimiter to end
      $this->path = rtrim($this->path, self::$delimiterPath);
    }
    $this->normalizeFragment($fragment);
  }

  /**
   * @param string|null $fragment
   */
  private function normalizeFragment(?string $fragment = null) {
    // normalize fragment
    if(!empty($fragment) && is_string($fragment) && $fragment !== self::$delimiterFragment) {
      // set delimiter to end
      $fragment = ltrim($fragment, self::$delimiterFragment);
    }
    $this->fragment = $fragment;
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
   * @param string|null $fragment
   *
   * @return $this
   */
  public function setFragment(?string $fragment = null) : self {
    $this->normalizeFragment($fragment);
    return $this;
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