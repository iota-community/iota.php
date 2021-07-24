<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Exception\Api;
  use IOTA\Exception\Helper;
  use PHPUnit\Framework\TestCase;
  use IOTA\Util\ApiCaller;

  /**
   * Class ApiCallerTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class ApiCallerTest extends TestCase {
    /**
     * @var string
     */
    protected string $url = 'https://api.lb-0.testnet.chrysalis2.com';
    /**
     * @var ApiCaller
     */
    protected ApiCaller $api;

    /**
     * @throws Api
     */
    protected function setUp(): void {
      $this->api = (new ApiCaller($this->url))->basePath('api/v1/')
                                              ->route('info');
    }

    /**
     * @throws Api
     */
    public function testfetchStatus() {
      $ret = $this->api->fetchStatus();
      $this->assertIsArray($ret);
      $this->assertArrayHasKey('url', $ret);
    }

    /**
     * @throws Api
     */
    public function testfetch() {
      $this->assertIsString($this->api->fetch());
    }

    /**
     * @throws Api
     * @throws Helper
     */
    public function testfetchArray() {
      $this->assertIsArray($this->api->fetchArray());
    }

    /**
     * @throws Api
     * @throws Helper
     */
    public function testfetchJSON() {
      $ret = $this->api->callback(IOTA\Api\v1\ResponseInfo::class)
                       ->fetchJSON();
      $this->assertInstanceOf(IOTA\Api\v1\ResponseInfo::class, $ret);
    }
  }
