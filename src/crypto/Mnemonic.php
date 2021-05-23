<?php namespace iota\crypto;
/**
 * Class Mnemonic
 *
 * @package iota\crypto
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
   * @param string $_passphrase
   * @param int    $iterations
   * @param int    $_keyLength
   * @param false  $_binary
   *
   * @return string
   */
  public function __toSeed(string $_passphrase = "", $iterations = 2048, int $_keyLength = 128, $_binary = false): string {
    return \iota\hash::pbkdf2Sha512(\implode(" ", $this->words), "mnemonic" . $_passphrase, 2048, $_keyLength, $_binary);
  }
}
