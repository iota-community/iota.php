<?php namespace IOTA\Crypto;
/**
 * Class Bip32Path
 *
 * @package      IOTA\Crypto
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Bip32Path {
  /**
   * @var array
   */
  protected array $_path = [];

  /**
   * Bip32Path constructor.
   *
   * @param string|null $_initPath
   */
  public function __construct(?string $_initPath = null) {
    if($_initPath) {
      $this->_path = explode("/", $_initPath);
      if($this->_path[0] === "m") {
        array_shift($this->_path);
      }
    }
  }

  /**
   * @param array $bip32Path
   *
   * @return Bip32Path
   */
  public function fromPath(array $bip32Path): Bip32Path {
    array_shift($bip32Path);

    return new Bip32Path(implode("/", $bip32Path));
  }

  /**
   * @param int  $index
   * @param bool $_hardend
   *
   * @return $this
   */
  public function setCoinType(int $index = 4218, bool $_hardend = true): self {
    $this->_path[1] = $index . ($_hardend ? "'" : "");

    return $this;
  }

  /**
   * @return int|null
   */
  public function getCoinType(): int|null {
    return $this->_path[1] ?? null;
  }

  /**
   * @param int  $index
   * @param bool $_hardend
   *
   * @return $this
   */
  public function setAccountIndex(int $index = 0, bool $_hardend = true): self {
    $this->_path[2] = $index . ($_hardend ? "'" : "");

    return $this;
  }

  /**
   * @return string|int|null
   */
  public function getAccountIndex(): string|int|null {
    return $this->_path[2] ?? null;
  }

  /**
   * @param int  $index
   * @param bool $_hardend
   *
   * @return $this
   */
  public function setAddressIndex(int $index = 0, bool $_hardend = true): self {
    $this->_path[4] = $index . ($_hardend ? "'" : "");

    return $this;
  }

  /**
   * @return string|int|null
   */
  public function getAddressIndex(): string|int|null {
    return $this->_path[4] ?? null;
  }

  /**
   * @param bool $val
   * @param bool $_hardend
   *
   * @return $this
   */
  public function setChange(bool $val = false, bool $_hardend = true): self {
    $this->_path[3] = ($val ? 1 : 0) . ($_hardend ? "'" : "");

    return $this;
  }

  /**
   * @return string|int|null
   */
  public function getChange(): string|int|null {
    return $this->_path[3] ?? null;
  }

  /**
   * @param int $index
   *
   * @return false|int
   */
  public function push(int $index): false|int {
    if(count($this->_path) >= 5) {
      return false;
    }

    return array_push($this->_path, $index);
  }

  /**
   * @param mixed $value
   *
   * @return false|int
   */
  public function pushHardened(mixed $value): false|int {
    return $this->push($value . "'");
  }

  /**
   * @return mixed
   */
  public function pop(): mixed {
    return array_pop($this->_path);
  }

  /**
   * @return array
   */
  public function numberSegments(): array {
    return array_map('intval', $this->_path);
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return count($this->_path) > 0 ? "m/" . implode("/", $this->_path) : "m";
  }
}
