<?php namespace iota\type\address;
/**
 * Class ed25519
 *
 * @package iota\type\address
 */
class ed25519 {
  /**
   * ed25519 constructor.
   *
   * @param string $publicKey
   */
  public function __construct(public string $publicKey) {

  }

  /**
   * @return string
   * @throws \SodiumException
   * @throws \iota\exception\converter
   */
  public function toAddress(): string {
    $_hash = \iota\hash::blake2b_sum256(\iota\converter::hex2bin($this->publicKey));

    return \iota\converter::bin2hex($_hash);
  }

  /**
   * @param string $hrp
   * @param int    $_addressType
   *
   * @return string
   * @throws \SodiumException
   * @throws \iota\exception\converter
   */
  public function toBech32Address(string $hrp, int $_addressType = 0): string {
    $_data = \iota\converter::hex2byteArray($this->toAddress());
    \array_unshift($_data, $_addressType);
    $_data = \iota\converter::bits($_data, count($_data), 8, 5, true);
    $_ret  = \iota\crypto\Bech32::encode($hrp, $_data);

    return $_ret;
  }

  /**
   * @return string
   * @throws \SodiumException
   * @throws \iota\exception\converter
   */
  public function __toString(): string {
    return $this->toAddress();
  }
}