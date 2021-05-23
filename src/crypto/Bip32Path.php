<?php namespace iota\crypto;
/**
 * Class Bip32Path
 *
 * @package iota\crypto
 */
class Bip32Path {
  /**
   * @var array
   */
  protected $_path = [];

  /**
   * Bip32Path constructor.
   *
   * @param string|null $_initPath
   */
  public function __construct(?string $_initPath = null) {
    if($_initPath) {
      $this->_path = \explode("/", $_initPath);
      if($this->_path[0] === "m") {
        \array_shift($this->_path);
      }
    }
  }

  /**
   * @param $bip32Path
   *
   * @return Bip32Path
   */
  public function fromPath($bip32Path): \iota\crypto\Bip32Path {
    \array_shift($bip32Path);

    return new \iota\crypto\Bip32Path($bip32Path);
  }

  /**
   *
   */
  public function push(mixed $value): void {
    \array_push($this->_path, $value);
  }

  /**
   * @param mixed $value
   */
  public function pushHardened(mixed $value): void {
    $this->push($value . "'");
  }

  /**
   *
   */
  public function pop(): void {
    \array_pop($this->_path);
  }

  /**
   * @return array
   */
  public function numberSegments(): array {
    return \array_map('intval', $this->_path);
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return \count($this->_path) > 0 ? "m/" . \implode("/", $this->_path) : "m";
  }
}
