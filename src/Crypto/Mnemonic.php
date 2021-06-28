<?php namespace IOTA\Crypto;

use IOTA\Exception\Helper as ExceptionHelper;
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

  public function __construct(string|array $words = []) {
    $this->words = is_string($words) ? explode(" ", $words) : $words;
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
}
