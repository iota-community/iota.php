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
   * @param $seed
   *
   * @return array
   */
  static public function keyPairFromSeed(string $seed): array {
    $_keys = \iota\converter::bin2hex(\sodium_crypto_sign_seed_keypair(\iota\converter::hex2bin($seed)));

    return [
      'privateKey' => \substr($_keys, 0, self::$PRIVATE_KEY_SIZE * 2),
      'publicKey'  => \substr($_keys, self::$PRIVATE_KEY_SIZE * 2, self::$PUBLIC_KEY_SIZE * 2),
    ];
  }
}