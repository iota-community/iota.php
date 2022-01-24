<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Helper\JSON;

  /**
   * Class JSONTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class JSONTest extends TestCase {
    protected JSON $object;
    protected string $str = "follow me on Twitter @IOTAphp";
    protected string $json = '{"data": "follow me on Twitter @IOTAphp"}';
    protected array $array = ['data' => "follow me on Twitter @IOTAphp"];

    public function setUp(): void {
      $this->object = new JSON($this->json);
    }

    public function testcreate() {
      $this->object = JSON::create($this->json);
      $this->assertInstanceOf('\IOTA\Helper\JSON', $this->object);
      $this->object = JSON::create($this->str);
      $this->assertInstanceOf('\IOTA\Helper\JSON', $this->object);
      $this->object = JSON::create($this->array);
      $this->assertInstanceOf('\IOTA\Helper\JSON', $this->object);
    }

    public function testdecode() {
      $ret = $this->object->__toArray();
      $this->assertIsArray((array)$ret);
    }

    public function testMAGIC() {
      $this->assertIsArray((array)$this->object);
      $this->assertIsString((string)$this->object);
    }
  }
