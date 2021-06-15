<?php namespace iota\type\seed;
/**
 * Class ed25519
 *
 * @package iota\type\seed
 */
class ed25519 {
  /**
   * @var string
   */
  protected $_secretKey;

  /**
   * ed25519 constructor.
   *
   * @param string $secretKey (as Hex)
   */
  public function __construct(string $secretKey) {
    $this->_secretKey = $secretKey;
  }

  /**
   * @param string|array $mnemonic
   *
   * @return ed25519
   * @throws \Exception
   */
  static public function fromMnemonic(string|array $mnemonic): \iota\type\seed\ed25519 {
    return new \iota\type\seed\ed25519(((new \iota\crypto\Bip39())->reverseMnemonic($mnemonic))->__toSeed());
  }

  /**
   * @param \iota\crypto\Bip32Path $path
   *
   * @return ed25519
   */
  public function generateSeedFromPath(\iota\crypto\Bip32Path $path): \iota\type\seed\ed25519 {
    $_keys = \iota\crypto\Slip0010::derivePath($this->_secretKey, $path);

    return new \iota\type\seed\ed25519($_keys['privateKey']);
  }

  /**
   * @return array
   */
  public function keyPair(): array {
    $signKeyPair = \iota\crypto\Ed25519::keyPairFromSeed($this->_secretKey);

    return [
      'publicKey'  => $signKeyPair['publicKey'],
      'privateKey' => $signKeyPair['privateKey'],
    ];
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->_secretKey;
  }
}