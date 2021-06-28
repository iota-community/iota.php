<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Exception\Crypto;
  use PHPUnit\Framework\TestCase;
  use IOTA\Crypto\Bech32;
  use IOTA\Helper\Converter;

  /**
   * Class Bech32Test
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class Bech32Test extends TestCase {
    protected string $hrp = "atoi";
    protected string $addressBech32 = "atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e";
    protected string $addressEd25519 = "60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe";

    /**
     * @throws Crypto
     * @throws \IOTA\Exception\Converter
     */
    public function testdecode(): void {
      $data = Bech32::decode($this->addressBech32)[1];
      $ret  = substr(Converter::byteArray2Hex(Converter::bits($data, count($data), 5, 8, false)), 2);
      $this->assertEquals($this->addressEd25519, $ret);
    }

    /**
     * @throws \iota\Exception\Converter
     */
    public function testencode(): void {
      $data = Converter::hex2byteArray($this->addressEd25519);
      array_unshift($data, 0);
      $ret = Bech32::encode($this->hrp, Converter::bits($data, count($data), 8, 5, true));
      $this->assertEquals($this->addressBech32, $ret);
    }
  }
