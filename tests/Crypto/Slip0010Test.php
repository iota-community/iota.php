<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Crypto\Bip32Path;
  use IOTA\Exception\Converter;
  use IOTA\Exception\Helper;
  use PHPUnit\Framework\TestCase;
  use IOTA\Crypto\Slip0010;

  /**
   * Class MnemonicTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class Slip0010Test extends TestCase {
    /**
     * @var Slip0010
     */
    protected Slip0010 $slip0010;
    /**
     * @var string
     */
    protected string $seed = "a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3";
    /**
     * @var string
     */
    protected string $privateKey = "f20f4d7d240ec181955f20f6f8958c198b687878f47278077c70972f0594153d";
    /**
     * @var string
     */
    protected string $chainCode = "33a35de0497e541a08d79abb445c449bc0fd93309e94b83dde543b7331270cbc";

    /**
     * @throws Converter
     * @throws Helper
     */
    public function testgetMasterKeyFromSeed(): void {
      $ret = Slip0010::getMasterKeyFromSeed($this->seed);
      $this->assertIsArray($ret);
      $this->assertIsString($ret['privateKey']);
      $this->assertIsString($ret['chainCode']);
      $this->assertEquals(64, strlen($ret['privateKey']));
      $this->assertEquals(64, strlen($ret['chainCode']));
      $this->assertEquals($this->privateKey, $ret['privateKey']);
      $this->assertEquals($this->chainCode, $ret['chainCode']);
    }

    /**
     * @throws Converter
     * @throws Helper
     */
    public function testderivePath(): void {
      $ret = Slip0010::derivePath($this->seed, new Bip32Path());
      $this->assertIsArray($ret);
      $this->assertIsString($ret['privateKey']);
      $this->assertIsString($ret['chainCode']);
      $this->assertEquals(64, strlen($ret['privateKey']));
      $this->assertEquals(64, strlen($ret['chainCode']));
      //
      $this->assertEquals($this->privateKey, $ret['privateKey']);
      $this->assertEquals($this->chainCode, $ret['chainCode']);
    }
  }
