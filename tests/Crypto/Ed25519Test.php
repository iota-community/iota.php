<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Exception\Converter;
  use PHPUnit\Framework\TestCase;
  use IOTA\Crypto\Ed25519;

  /**
   * Class MnemonicTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class Ed25519Test extends TestCase {
    /**
     * @var Ed25519
     */
    protected Ed25519 $ed25519;
    /**
     * @var string
     */
    protected string $secretKey = "a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3";
    /**
     * @var string
     */
    protected string $signed = "27068ebb3fa0af6f4cc67b464fb9ff162a70470e18b88db6e4ef0e41dd8fe6527326abbcf1f49647fcebb8e8da9c65fa1f999417ed911dc3a4f9260f722e3e0d";
    /**
     * @var string
     */
    protected string $seed = "52d23081a626b1eca34b63f1eaeeafcbd66bf545635befc12cd0f19926efefb0";
    /**
     * @var string
     */
    protected string $privateKey = "52d23081a626b1eca34b63f1eaeeafcbd66bf545635befc12cd0f19926efefb031f176dadf38cdec0eadd1d571394be78f0bbee3ed594316678dffc162a095cb";
    /**
     * @var string
     */
    protected string $publicKey = "31f176dadf38cdec0eadd1d571394be78f0bbee3ed594316678dffc162a095cb";

    /**
     * @throws SodiumException
     * @throws Converter
     */
    public function testkeyPairFromSeed(): void {
      $ret = Ed25519::keyPairFromSeed($this->seed);
      $this->assertIsArray($ret);
      $this->assertIsString($ret['privateKey']);
      $this->assertIsString($ret['publicKey']);
      $this->assertEquals(128, strlen($ret['privateKey']));
      $this->assertEquals(64, strlen($ret['publicKey']));
      $this->assertEquals($this->privateKey, $ret['privateKey']);
      $this->assertEquals($this->publicKey, $ret['publicKey']);
    }

    /**
     * @throws SodiumException
     * @throws Converter
     */
    public function testsign(): void {
      $ret = Ed25519::sign($this->secretKey, $this->seed);
      $this->assertIsString($ret);
      $this->assertEquals(128, strlen($ret));
      $this->assertEquals($this->signed, $ret);
    }
  }
