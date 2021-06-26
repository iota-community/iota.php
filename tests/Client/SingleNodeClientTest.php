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
    public function testhealth() {
      $this->assertIsBool($this->client->health());
    }

    /**
     * @throws ExceptionApi|ExceptionHelper
     */
    public function testinfo() {
      $this->assertInstanceOf(ResponseInfo::class, $this->client->info());
    }

    /**
     * @throws ExceptionApi|ExceptionHelper
     */
    public function testtips() {
      $this->assertInstanceOf(ResponseTips::class, $this->client->tips());
    }

    /**
     * @var ResponseSubmitMessage
     */
    private ResponseSubmitMessage $lastResponseSubmitMessage;

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testsubmitMessage() {
      $payload = new PayloadIndexation('#iota.php', 'message test! follow me on Twitter @IOTAphp');
      $message = new RequestSubmitMessage($payload);
      $this->assertInstanceOf(ResponseSubmitMessage::class, $this->client->messageSubmit($message));
      $this->assertInstanceOf(ResponseSubmitMessage::class, ($this->lastResponseSubmitMessage = $this->client->messageSubmit($payload)));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmessage() {
      if(!isset($this->lastResponseSubmitMessage)) {
        $this->testsubmitMessage();
      }
      $ret = $this->client->message($this->lastResponseSubmitMessage->messageId);
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
      }
      else {
        $this->assertInstanceOf(ResponseMessage::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmessageRaw() {
      if(!isset($this->lastResponseSubmitMessage)) {
        $this->testsubmitMessage();
      }
      $ret = $this->client->messageRaw($this->lastResponseSubmitMessage->messageId);
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
      }
      else {
        $this->assertTrue(Converter::isBinary($ret));
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmessageChildren() {
      if(!isset($this->lastResponseSubmitMessage)) {
        $this->testsubmitMessage();
      }
      $ret = $this->client->messageChildren($this->lastResponseSubmitMessage->messageId);
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
      }
      else {
        $this->assertInstanceOf(ResponseMessageChildren::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmessageMetadata() {
      if(!isset($this->lastResponseSubmitMessage)) {
        $this->testsubmitMessage();
      }
      $ret = $this->client->messageMetadata($this->lastResponseSubmitMessage->messageId);
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
      }
      else {
        $this->assertInstanceOf(ResponseMessageMetadata::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmessageFind() {
      $this->assertInstanceOf(ResponseMessagesFind::class, $this->client->messagesFind(Converter::string2Hex("#iota.php")));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmilestone() {
      $info = $this->client->info();

      $ret = $this->client->milestone($info->latestMilestoneIndex);
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(403, $ret->code);
      }
      else {
        $this->assertInstanceOf(ResponseMilestone::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmilestoneUtxoChanges() {
      $info = $this->client->info();
      $this->assertInstanceOf(ResponseMilestoneUtxoChanges::class, $this->client->milestoneUtxoChanges($info->latestMilestoneIndex));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testpeers() {
      $ret = $this->client->peers();
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(403, $ret->code);
      }
      else {
        $this->assertInstanceOf(ResponsePeers::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testpeer() {
      $ret = $this->client->peer("12D3KooWFB9udoQ2wUe1mFkh4uSaqGZWW8pk33ariKpLEuTL4XWB");
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(403, $ret->code);
      }
      else {
        $this->assertInstanceOf(ResponsePeer::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testpeerAdd() {
      $ret = $this->client->peer("/ip4/178.238.226.117/tcp/15600/p2p/12D3KooWFB9udoQ2wUe1mFkh4uSaqGZWW8pk33ariKpLEuTL4XWB");
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(403, $ret->code);
      }
      else {
        $this->assertInstanceOf(ResponsePeer::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testpeerDelete() {
      $ret = $this->client->peer("12D3KooWFB9udoQ2wUe1mFkh4uSaqGZWW8pk33ariKpLEuTL4XWB");
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(403, $ret->code);
      }
      else {
        $this->assertNull($ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testoutput() {
      $this->assertInstanceOf(ResponseOutput::class, $this->client->output("c7f1f4d740e52b94137e81fbb5eb94abbfc519ccece87172e3b3d457d88c45440000"));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testaddress() {
      $this->assertInstanceOf(ResponseBalanceAddress::class, $this->client->address("atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e"));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testaddressesOutput() {
      $this->assertInstanceOf(ResponseOutputAddress::class, $this->client->addressesOutput("atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e"));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testaddressEd25519() {
      $this->assertInstanceOf(ResponseBalanceAddress::class, $this->client->addressEd25519("60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe"));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testaddressesOutputEd25519() {
      $this->assertInstanceOf(ResponseOutputAddress::class, $this->client->addressesed25519Output("60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe"));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testreceipts() {
      $ret = $this->client->receipts();
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(403, $ret->code);
      }
      else {
        $this->assertInstanceOf(ResponseReceipts::class, $ret);
      }
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testtreasury() {
      $this->assertInstanceOf(ResponseTreasury::class, $this->client->treasury());
    }
  }
