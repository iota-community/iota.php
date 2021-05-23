<?php namespace iota\crypto;
/**
 * Class Slip0010
 *
 * @package iota\crypto
 */
class Slip0010 {
  /**
   * @var int
   */
  static protected int $PRIVATE_KEY_SIZE = 32;
  /**
   * @var int
   */
  static protected int $CHAIN_CODE_SIZE = 32;
  /**
   * @var int
   */
  static protected int $indexValue = 0x80000000;

  /**
   * @param string $seed
   *
   * @return array
   * @throws \iota\exception\converter
   * @throws \iota\exception\hash
   */
  static public function getMasterKeyFromSeed(string $seed): array {
    $_key = \iota\hash::hmacSha512("ed25519 seed")
                      ->update(\iota\converter::hex2bin($seed))
                      ->digest();

    return [
      'privateKey' => \substr($_key, 0, self::$PRIVATE_KEY_SIZE * 2),
      'chainCode'  => \substr($_key, self::$PRIVATE_KEY_SIZE * 2, self::$CHAIN_CODE_SIZE * 2),
    ];
  }

  /**
   * @param string    $seed
   * @param Bip32Path $path
   *
   * @return array
   * @throws \iota\exception\converter
   * @throws \iota\exception\hash
   */
  static public function derivePath(string $seed, \iota\crypto\Bip32Path $path): array {
    $_keys      = self::getMasterKeyFromSeed($seed);
    $privateKey = $_keys['privateKey'];
    $chainCode  = $_keys['chainCode'];
    //
    foreach($path->numberSegments() as $index) {
      $indexHex = \str_pad(\dechex($index + self::$indexValue), 8, "0", STR_PAD_LEFT);
      $_key     = \iota\hash::hmacSha512(\iota\converter::hex2bin($chainCode))
                            ->update(\iota\converter::hex2bin("00" . $privateKey . $indexHex))
                            ->digest();
      //
      $privateKey = \substr($_key, 0, self::$PRIVATE_KEY_SIZE * 2);
      $chainCode  = \substr($_key, self::$PRIVATE_KEY_SIZE * 2, self::$CHAIN_CODE_SIZE * 2);
    }

    return [
      'privateKey' => $privateKey,
      'chainCode'  => $chainCode,
    ];
  }
}
