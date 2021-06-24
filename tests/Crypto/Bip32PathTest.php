<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Crypto\Bip32Path;

  /**
   * Class Bip32PathTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class Bip32PathTest extends TestCase {
    /**
     * @var Bip32Path
     */
    protected Bip32Path $path;
    /**
     * @var string
     */
    protected string $pathString = "m/44'/4218'/0'/0'/0'";
    /**
     * @var array|string[]
     */
    protected array $pathArray = [
      "m",
      "44'",
      "4218'",
      "0'",
      "0'",
      "0'",
    ];

    /**
     *
     */
    protected function setUp(): void {
      $this->path = new Bip32Path($this->pathString);
    }

    /**
     *
     */
    public function testfromPath(): void {
      $this->assertInstanceOf(Bip32Path::class, $this->path->fromPath($this->pathArray));
    }

    /**
     *
     */
    public function testsetCoinType() {
      $this->path->setCoinType(4218, false);
      $this->assertEquals(4218, (explode("/", (string)$this->path))[2]);
      $this->path->setCoinType(4218, true);
      $this->assertEquals("4218'", (explode("/", (string)$this->path))[2]);
    }

    /**
     *
     */
    public function testsetAccountIndex() {
      $this->path->setAccountIndex(0, false);
      $this->assertEquals(0, (explode("/", (string)$this->path))[3]);
      $this->path->setAccountIndex(0, true);
      $this->assertEquals("0'", (explode("/", (string)$this->path))[3]);
    }

    /**
     *
     */
    public function testsetAddressIndex() {
      $this->path->setAddressIndex(0, false);
      $this->assertEquals(0, (explode("/", (string)$this->path))[5]);
      $this->path->setAddressIndex(0, true);
      $this->assertEquals("0'", (explode("/", (string)$this->path))[5]);
    }

    /**
     *
     */
    public function testsetChange() {
      $this->path->setChange(true, false);
      $this->assertEquals(1, (explode("/", (string)$this->path))[4]);
      $this->path->setChange(false, false);
      $this->assertEquals(0, (explode("/", (string)$this->path))[4]);
      $this->path->setChange(true, true);
      $this->assertEquals("1'", (explode("/", (string)$this->path))[4]);
      $this->path->setChange(false, true);
      $this->assertEquals("0'", (explode("/", (string)$this->path))[4]);
    }

    /**
     *
     */
    public function testpush() {
      $this->assertFalse($this->path->push(0));
    }

    /**
     *
     */
    public function testpushHardened() {
      $this->assertFalse($this->path->push(0));
    }

    /**
     *
     */
    public function testpop() {
      $this->assertFalse($this->path->push(0));
    }

    /**
     *
     */
    public function testnumberSegments() {
      $this->assertIsArray($this->path->numberSegments());
      $this->assertEquals("44", $this->path->numberSegments()[0]);
      $this->assertEquals("4218", $this->path->numberSegments()[1]);
      $this->assertEquals("0", $this->path->numberSegments()[2]);
      $this->assertEquals("0", $this->path->numberSegments()[3]);
      $this->assertEquals("0", $this->path->numberSegments()[4]);
    }

    /**
     *
     */
    public function testMAGIC() {
      $this->assertIsString($this->path->__toString());
    }
  }
