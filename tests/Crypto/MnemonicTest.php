<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Exception\Helper;
  use PHPUnit\Framework\TestCase;
  use IOTA\Crypto\Mnemonic;

  /**
   * Class MnemonicTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class MnemonicTest extends TestCase {
    /**
     * @var Mnemonic
     */
    protected Mnemonic $mnemonic;
    /**
     * @var string
     */
    protected string $words = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
    /**
     * @var string
     */
    protected string $seed = "a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3";

    /**
     *
     */
    protected function setUp(): void {
      $this->mnemonic        = new Mnemonic();
      $this->mnemonic->words = explode(" ", $this->words);
    }

    /**
     * @throws Helper
     */
    public function testMAGIC(): void {
      $ret = $this->mnemonic->__toSeed();
      $this->assertIsString($ret);
      $this->assertEquals($this->seed, $ret);
    }
  }
