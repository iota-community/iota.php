<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Action\getMessage;
  use IOTA\Action\sendMessage;
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\ResponseMessage;

  /**
   * Class getMessageTest
   *
   * @author       StefanBraun @tanglePHP
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class getMessageTest extends TestCase {

    /**
     * @var SingleNodeClient
     */
    protected SingleNodeClient $client;


    /**
     *
     */
    public function setUp(): void {
      $this->client = new SingleNodeClient();
      $this->assertInstanceOf(SingleNodeClient::class, $this->client);
    }

    /**
     *
     */
    public function testgetMessage() {
      $msg = (new sendMessage($this->client))->index('#tanglePHP')
                                             ->data('message test! follow me on Twitter @tanglePHP')->run();

      $ret = (new getMessage($this->client))->messageId($msg->messageId);
      $this->assertInstanceOf(getMessage::class, $ret);
      $this->assertInstanceOf(ResponseMessage::class, $ret->getResult());
    }
  }
