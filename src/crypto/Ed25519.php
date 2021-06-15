<?php namespace iota\crypto;
/**
 * Class Ed25519
 *
 * @package iota\crypto
 */
class Ed25519 {
  /**
   * @var int
   */
  static protected int $PUBLIC_KEY_SIZE = 32;
  /**
   * @var int
   */
  static protected int $PRIVATE_KEY_SIZE = 64;
  /**
   * @var int
   */
  static protected int $SEED_SIZE = 32;

  /**
   * @param string $seed
   *
   * @return array
   * @throws \SodiumException
   * @throws \iota\exception\converter
   */
  static public function keyPairFromSeed(string $seed): array {
    $_keys = \iota\converter::bin2hex(\sodium_crypto_sign_seed_keypair(\iota\converter::hex2bin($seed)));

    return [
      'privateKey' => \substr($_keys, 0, self::$PRIVATE_KEY_SIZE * 2),
      'publicKey'  => \substr($_keys, self::$PRIVATE_KEY_SIZE * 2, self::$PUBLIC_KEY_SIZE * 2),
    ];
  }

  /**
   * @param string $secretKey
   * @param string $message
   *
   * @return string
   * @throws \SodiumException
   * @throws \iota\exception\converter
   */
  static public function sign(string $secretKey, string $message) {
    $_sign = \iota\converter::bin2hex(\sodium_crypto_sign(\iota\converter::hex2bin($message), \iota\converter::hex2bin($secretKey)));

    return \substr($_sign, 0, self::$PRIVATE_KEY_SIZE * 2);
  }
}
