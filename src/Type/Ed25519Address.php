<?php namespace IOTA\Type;

use IOTA\Helper\Converter;
use IOTA\Helper\Hash;
use SodiumException;
use IOTA\Exception\Converter as ExceptionConverter;

/**
 * Class Ed25519Address
 *
 * @package      IOTA\Type
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Ed25519Address {
  /**
   * ed25519 constructor.
   *
   * @param string $publicKey
   */
  public function __construct(public string $publicKey) {

  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function toAddress(): string {
    $_hash = Hash::blake2b_sum256(Converter::hex2String($this->publicKey));

    return Converter::string2Hex($_hash);
  }

  /**
   * @param string $hrp
   *
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function toAddressBetch32(string $hrp): string {
    return Converter::ed25519ToBech32($this->toAddress(), $hrp);
  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function toAddressBase58(): string {
    return Converter::base58_encode($this->toAddress());
  }


  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function __toString(): string {
    return $this->toAddress();
  }
}