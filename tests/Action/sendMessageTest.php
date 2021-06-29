<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Action\sendMessage;
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\ResponseSubmitMessage;

  /**
   * Class sendMessageTest
   *
   * @author       StefanBraun @IOTAphp
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class sendMessageTest extends TestCase {
    /**
     * @var string
     */
    protected string $index = "#iota.php";
    /**
     * @var string
     */
    protected string $message = "message test! follow me on Twitter @IOTAphp";
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
    public function testsendMessage() {
      $ret = (new sendMessage($this->client))->index('#iota.php')
                                             ->data('message test! follow me on Twitter @IOTAphp');

      $this->assertInstanceOf(sendMessage::class, $ret);
      $this->assertInstanceOf(ResponseSubmitMessage::class, $ret->getResult());
    }
  }
