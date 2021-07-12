<?php namespace IOTA;

use IOTA\Client\SingleNodeClient;
use IOTA\Crypto\Bip39;
use IOTA\Crypto\Mnemonic;
use IOTA\Type\Ed25519Seed;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Type as ExceptionType;
use SodiumException;

/**
 * Class Wallet
 *
 * @package      IOTA\Type
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Wallet {
  /**
   * @var SingleNodeClient
   */
  public SingleNodeClient $client;
  /**
   * @var Ed25519Seed
   */
  protected Ed25519Seed $_seed;
  /**
   * @var array
   */
  protected array $addresses;
  /**
   * @var string
   */
  public string $bech32HRP;

  /**
   * Wallet constructor.
   *
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param SingleNodeClient|null             $client
   *
   * @throws Exception\Api
   * @throws Exception\Converter
   * @throws Exception\Crypto
   * @throws Exception\Helper
   * @throws Exception\Type
   */
  public function __construct(Ed25519Seed|Mnemonic|string|array $seedInput, ?SingleNodeClient $client = null) {
    $this->_seed     = new Ed25519Seed($seedInput);
    $this->client    = $client ?? new SingleNodeClient();
    $this->bech32HRP = $this->client->info()->bech32HRP;
  }

  /**
   * @return Mnemonic
   * @throws Exception\Converter
   * @throws Exception\Crypto
   * @throws Exception\Helper
   */
  static public function createMnemonic(): Mnemonic {
    return (new Bip39())->randomMnemonic();
  }

  /**
   * @param int  $accountIndex
   * @param int  $addressIndex
   * @param bool $isInternal
   *
   * @return Wallet\Address
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function address(int $accountIndex = 0, int $addressIndex = 0, bool $isInternal = false): Wallet\Address {
    $add                                    = new Wallet\Address($this, $accountIndex, $addressIndex, $isInternal);
    $this->addresses[$add->getPathString()] = $add;

    return $add;
  }

  /**
   * @return Ed25519Seed
   */
  public function getSeed(): Ed25519Seed {
    return $this->_seed;
  }

  /**
   * @param int  $maxAccountIndex
   * @param int  $maxAddressIndex
   * @param bool $zeroBalance
   *
   * @return array
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws Exception\Api
   * @throws SodiumException
   */
  public function searchAddresses(int $maxAccountIndex = 5, int $maxAddressIndex = 5, bool $zeroBalance = false): array {
    $_ret = [];
    for($_i = 0; $_i < $maxAccountIndex; $_i++) {
      for($_j = 0; $_j < $maxAddressIndex; $_j++) {
        $_r = $this->address($_i, $_j);
        if(($_r->getBalance()) == 0 && $zeroBalance == false) {
          continue;
        }
        $_ret[] = $_r->__toArray();
      }
    }

    return $_ret;
  }

  /**
   * @return array
   */
  public function getKnownAddresses() : array {
    return $this->addresses;
  }
}