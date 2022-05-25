<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Exception\Helper as ExceptionHelper;
  use IOTA\Exception\Api as ExceptionApi;
  use IOTA\Helper\Converter;
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\ResponseError;
  use IOTA\Api\v1\ResponseInfo;
  use IOTA\Api\v1\ResponseMessage;
  use IOTA\Api\v1\ResponseTips;
  use IOTA\Api\v1\ResponseMessageChildren;
  use IOTA\Api\v1\ResponseMessageMetadata;
  use IOTA\Api\v1\ResponseMessagesFind;
  use IOTA\Api\v1\ResponseSubmitMessage;
  use IOTA\Api\v1\RequestSubmitMessage;
  use IOTA\Api\v1\ResponseMilestone;
  use IOTA\Api\v1\ResponseMilestoneUtxoChanges;
  use IOTA\Api\v1\ResponsePeers;
  use IOTA\Api\v1\ResponsePeer;
  use IOTA\Api\v1\ResponseOutput;
  use IOTA\Api\v1\ResponseBalanceAddress;
  use IOTA\Api\v1\ResponseOutputAddress;
  use IOTA\Api\v1\ResponseReceipts;
  use IOTA\Api\v1\ResponseTreasury;
  use IOTA\Api\v1\PayloadIndexation;

  /**
   * Class SingleNodeClientTest
   *
   * @author       StefanBraun
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class SingleNodeClientTest extends TestCase {
    /**
     * @var SingleNodeClient
     */
    protected SingleNodeClient $client;

    /**
     *
     */
    protected function setUp(): void {
      $this->client = new SingleNodeClient();
    }

    /**
     * @throws ExceptionApi
     */
    public function testClientNetwork() {
      $this->client = new SingleNodeClient('devnet');
      $this->assertIsBool($this->client->health());
      $this->client = new SingleNodeClient('mainnet');
      $this->assertIsBool($this->client->health());
      $this->client = new SingleNodeClient('https://api.lb-0.h.chrysalis-devnet.iota.cafe/');
      $this->assertIsBool($this->client->health());
      $this->client = new SingleNodeClient(\IOTA\Helper\Network::devnet);
      $this->assertIsBool($this->client->health());
    }

    /**
     * @throws ExceptionApi
     */
    public function testhealth() {
      $this->assertIsBool($this->client->health());
    }

    /**
     * @throws ExceptionApi|ExceptionHelper
     */
    public function testinfo() {
      $this->assertInstanceOf(ResponseInfo::class, $this->client->info());
    }
  }
