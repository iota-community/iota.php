<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Exception\Helper as ExceptionHelper;
  use IOTA\Exception\Api as ExceptionApi;
  use IOTA\Client\PermaNodeClient;
  use IOTA\Api\v1\ResponseError;
  use IOTA\Api\v1\ResponseInfo;
  use IOTA\Api\v1\ResponseMessage;
  use IOTA\Api\v1\ResponseMessageChildren;
  use IOTA\Api\v1\ResponseMessageMetadata;
  use IOTA\Api\v1\ResponseMessagesFind;
  use IOTA\Api\v1\ResponseMilestone;
  use IOTA\Api\v1\ResponseOutput;

  /**
   * Class PermaNodeClientTest
   *
   * @author       StefanBraun @IOTAphp
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class PermaNodeClientTest extends TestCase {
    /**
     * @var PermaNodeClient
     */
    protected PermaNodeClient $client;

    /**
     *
     */
    protected function setUp(): void {
      $this->client = new PermaNodeClient();
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
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmessage() {
      $ret = $this->client->message('adbc49b03fa4afdf0ff961b47937a928f5e5efc01d684dcdf0dde296004f094c');
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
    public function testmessageChildren() {
      $ret = $this->client->messageChildren('adbc49b03fa4afdf0ff961b47937a928f5e5efc01d684dcdf0dde296004f094c');
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
      $ret = $this->client->messageMetadata('adbc49b03fa4afdf0ff961b47937a928f5e5efc01d684dcdf0dde296004f094c');
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
      $this->assertInstanceOf(ResponseMessagesFind::class, $this->client->messagesFind("#iota.php"));
    }

    /**
     * @throws ExceptionApi
     * @throws ExceptionHelper
     */
    public function testmilestone() {
      $ret = $this->client->milestone('1');
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
    public function testoutput() {
      $ret = $this->client->output("c7f1f4d740e52b94137e81fbb5eb94abbfc519ccece87172e3b3d457d88c45440000");
      if($ret instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret);
        $this->assertEquals(404, $ret->code);
      }
      else {
        $this->assertInstanceOf(ResponseOutput::class, $ret);
      }
    }
  }
