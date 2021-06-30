<?php namespace IOTA\Crypto;

use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Helper\Hash;

/**
 * Class Mnemonic
 *
 * @package      IOTA\Crypto
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Mnemonic {
  /**
   * @var array
   */
  public array $words = [];
  /**
   * @var array
   */
  public array $wordsIndex = [];
  /**
   * @var int
   */
  public int $wordsCount = 0;
  /**
   * @var array
   */
  public array $rawBinaryChunks = [];
  /**
   * @var string|null
   */
  public ?string $entropy;

  /**
   * Mnemonic constructor.
   *
   * @param string|array $words
   */
  public function __construct(string|array $words = []) {
    $this->words = is_string($words) ? explode(" ", $words) : $words;
  }

  /**
   * @return Mnemonic
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   */
  static public function createRandom(): Mnemonic {
    return new Mnemonic((new Bip39())->randomMnemonic()->words);
  }

  /**
   * @param string $_passphrase
   * @param int    $iterations
   * @param int    $_keyLength
   * @param bool   $_binary
   *
   * @return string
   * @throws ExceptionHelper
   */
  public function __toSeed(string $_passphrase = "", int $iterations = 2048, int $_keyLength = 128, bool $_binary = false): string {
    return Hash::pbkdf2Sha512(implode(" ", $this->words), "mnemonic" . $_passphrase, 2048, $_keyLength, $_binary);
  }

  /**
   * @return string
   */
  public function __toString() {
    return implode(" ", $this->words);
  }

}
