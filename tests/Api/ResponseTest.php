<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Api\v1\Response;

  /**
   * Class ResponseTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class ResponseTest extends TestCase {
    protected string $str = "follow me on Twitter @IOTAphp";
    protected string $json = '{"data": "follow me on Twitter @IOTAphp"}';
    protected array $array = ['data' => "follow me on Twitter @IOTAphp"];
    protected string $jsonError = '{"error":{"code":"403","message":"Forbidden, error: code=403, message=Forbidden"}}';

    public function testJSON() {
      $ret = new Response($this->json);
      $this->assertInstanceOf(Response::class, $ret);
    }

    public function teststring() {
      $ret = new Response($this->str);
      $this->assertInstanceOf(Response::class, $ret);
    }

    public function testarray() {
      $ret = new Response($this->array);
      $this->assertInstanceOf(Response::class, $ret);
    }
  }
