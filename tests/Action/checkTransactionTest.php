<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Action\checkTransaction;
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\ResponseMessageMetadata;
  use IOTA\Api\v1\ResponseError;

  /**
   * Class checkTransactionTest
   *
   * @author       StefanBraun @tanglePHP
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class checkTransactionTest extends TestCase {
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
    public function testcheckTransaction() {
      $ret = (new checkTransaction($this->client))->messageId('fcb61f2d45686c539c3437437b2c381cc1bc87959f8ef56cf51919ed86ed1676');
      $result = $ret->getResult();
      if($result instanceof ResponseError) {
        $this->assertInstanceOf(ResponseError::class, $ret->getResult());
      }
      else {
        $this->assertIsString(checkTransaction::class, $ret->run());
        $this->assertInstanceOf(ResponseMessageMetadata::class, $result);
      }
    }
  }
