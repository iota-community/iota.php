<?php namespace IOTA\Crypto;

use IOTA\Exception\Converter as ExceptionConverter;
use SodiumException;
use IOTA\Helper\Converter;
use function sodium_crypto_sign;
use function sodium_crypto_sign_seed_keypair;

/**
 * Class Ed25519
 *
 * @package iota\crypto
 */
class Ed25519 {
  /**
   * @var int
   */
  static public int $PUBLIC_KEY_SIZE = 32;
  /**
   * @var int
   */
  static public int $PRIVATE_KEY_SIZE = 64;
  /**
   * @var int
   */
  static public int $SEED_SIZE = 32;

  /**
   * @return array
   * @throws SodiumException
   */
  static public function keyPair(): array {
    $_keys = Converter::string2hex(sodium_crypto_sign_keypair());

    return [
      'privateKey' => substr($_keys, 0, self::$PRIVATE_KEY_SIZE * 2),
      'publicKey'  => substr($_keys, self::$PRIVATE_KEY_SIZE * 2, self::$PUBLIC_KEY_SIZE * 2),
    ];
  }

  /**
   * @param string $keyPair
   *
   * @return string
   * @throws SodiumException
   */
  static public function secretKey(string $keyPair) {
    $keyPair = Converter::isHex($keyPair) ? Converter::hex2String($keyPair) : $keyPair;

    //
    return Converter::string2Hex(sodium_crypto_sign_secretkey($keyPair));
  }

  /**
   * @param string $seed
   *
   * @return array
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  static public function keyPairFromSeed(string $seed): array {
    $seed = Converter::isHex($seed) ? Converter::hex2String($seed) : $seed;
    //
    $_keys = Converter::string2hex(sodium_crypto_sign_seed_keypair($seed));

    return [
      'privateKey' => substr($_keys, 0, self::$PRIVATE_KEY_SIZE * 2),
      'publicKey'  => substr($_keys, self::$PRIVATE_KEY_SIZE * 2, self::$PUBLIC_KEY_SIZE * 2),
    ];
  }

  /**
   * @param string $secretKey
   * @param string $message
   *
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  static public function sign(string $secretKey, string $message): string {
    $message   = Converter::isHex($message) ? Converter::hex2String($message) : $message;
    $secretKey = Converter::isHex($secretKey) ? Converter::hex2String($secretKey) : $secretKey;
    //
    $_sign = Converter::string2hex(sodium_crypto_sign_detached($message, $secretKey));

    return substr($_sign, 0, self::$PRIVATE_KEY_SIZE * 2);
  }

  /**
   * @param string $signedMessage
   * @param string $publiKey
   *
   * @return string|false
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  static public function open(string $signedMessage, string $publiKey): string|false {
    $signedMessage = Converter::isHex($signedMessage) ? Converter::hex2String($signedMessage) : $signedMessage;
    $publiKey      = Converter::isHex($publiKey) ? Converter::hex2String($publiKey) : $publiKey;

    //
    return sodium_crypto_sign_open($signedMessage, $publiKey);
  }

  /**
   * @param $sign
   * @param $message
   * @param $publicKey
   *
   * @return bool
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  static public function verify_detached($sign, $message, $publicKey): bool {
    $sign      = Converter::isHex($sign) ? Converter::hex2String($sign) : $sign;
    $message   = Converter::isHex($message) ? Converter::hex2String($message) : $message;
    $publicKey = Converter::isHex($publicKey) ? Converter::hex2String($publicKey) : $publicKey;

    //
    return sodium_crypto_sign_verify_detached($sign, $message, $publicKey);
  }
}
