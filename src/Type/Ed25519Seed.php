<?php namespace IOTA\Type;

use IOTA\Crypto\Bip32Path;
use IOTA\Crypto\Bip39;
use IOTA\Crypto\Ed25519;
use IOTA\Crypto\Mnemonic;
use IOTA\Crypto\Slip0010;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Exception\Type as ExceptionType;
use IOTA\Helper\Converter;
use SodiumException;

/**
 * Class Ed25519Seed
 *
 * @package      IOTA\Type
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Ed25519Seed {
  /**
   * @var string
   */
  public string $secretKey;

  /**
   * Ed25519Seed constructor.
   *
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   *
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  public function __construct(Ed25519Seed|Mnemonic|string|array $seedInput) {
    if(is_string($seedInput) && (strlen($seedInput) == 64 || strlen($seedInput) == 128) && Converter::isHex($seedInput)) {
      $this->secretKey = $seedInput;
    }
    elseif($seedInput instanceof Mnemonic || (is_string($seedInput) && str_word_count($seedInput) == 24) || (is_array($seedInput) && count($seedInput))) {
      if($seedInput instanceof Mnemonic) {
        $seedInput = $seedInput->words;
      }
      $this->secretKey = ((new Bip39())->reverseMnemonic($seedInput))->__toSeed();
    }
    elseif($seedInput instanceof Ed25519Seed) {
      $this->secretKey = $seedInput->secretKey;
    }
    else {
      throw new ExceptionType("Unknwon seedInput");
    }
  }

  /**
   * @param Bip32Path $path
   *
   * @return Ed25519Seed
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  public function generateSeedFromPath(Bip32Path $path): Ed25519Seed {
    $_keys = Slip0010::derivePath($this->secretKey, $path);

    return new Ed25519Seed($_keys['privateKey']);
  }

  /**
   * @return array
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function keyPair(): array {
    $signKeyPair = Ed25519::keyPairFromSeed($this->secretKey);

    return [
      'publicKey'  => $signKeyPair['publicKey'],
      'privateKey' => $signKeyPair['privateKey'],
    ];
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->secretKey;
  }
}