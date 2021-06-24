<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Action\sendTokens;
  use IOTA\Exception\Helper;
  use IOTA\Models\AbstractApiResponse;
  use PHPUnit\Framework\TestCase;
  use IOTA\Exception\Api as ExceptionApi;
  use IOTA\Client\FaucetClient;

  /**
   * Class FaucetClientTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class FaucetClientTest extends TestCase {
    protected FaucetClient $client;

    /**
     *
     */
    protected function setUp(): void {
      $this->client = new FaucetClient();
    }

    /**
     * @throws ExceptionApi
     * @throws Helper
     */
    public function testget() {
      $this->assertInstanceOf(AbstractApiResponse::class, $this->client->get("atoi1qpnknjkytwhj009uaucksr03azlz45c4nl5palf2hptsnn5m5hvt5kjllcp"));
    }

    /**
     *
     */
    public function testsend() {
      $this->assertInstanceOf(sendTokens::class, $this->client->send("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally", 0, 1000000));
    }
  }
