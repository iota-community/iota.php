<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use IOTA\Exception\Helper;
  use IOTA\Models\AbstractApiResponse;
  use PHPUnit\Framework\TestCase;
  use IOTA\Exception\Api as ExceptionApi;
  use IOTA\Client\FaucetClient;
  use IOTA\Api\v1\ResponseSubmitMessage;

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
      try {
        $ret = $this->client->get("atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e");
        if($ret instanceof \IOTA\Api\v1\ResponseError) {
          throw new \IOTA\Exception\Action($ret->message);
        }
        else {
          $this->assertInstanceOf(\IOTA\Helper\JSON::class, $ret);
        }
      }
      catch(\IOTA\Exception\Action $e) {
        if($e->getMessage() == "You already have enough coins on your address.") {
          $this->assertTrue(true);

          return;
        }
        throw new Exception($e->getMessage());
      }
    }

    /**
     *
     */
    public function testsend() {
      try {
        $ret = $this->client->send("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally", 0, 1000000);
        if($ret instanceof \IOTA\Api\v1\ResponseError) {
          throw new \IOTA\Exception\Action($ret->message);
        }
        else {
          $this->assertInstanceOf(ResponseSubmitMessage::class, $ret);
        }
      }
      catch(\IOTA\Exception\Action $e) {
        if($e->getMessage() == "There are not enough funds in the inputs for the required balance! amount: 1000000, balance: 0") {
          $this->assertTrue(true);

          return;
        }
        throw new Exception($e->getMessage());
      }
    }
  }
