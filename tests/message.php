<?php declare(strict_types = 1);
  require_once("./iota.php");

  use PHPUnit\Framework\TestCase;

  /**
   * Class message
   */
  final class message extends TestCase {
    /**
     * @var iota
     */
    protected $_client;

    /**
     *
     */
    public function createApiClient(): void {
      if(!\is_object($this->_client)) {
        $this->_client = new iota('https://api.lb-0.testnet.chrysalis2.com');
      }
    }

    /**
     * @var
     */
    private $_lastMessageId;

    /**
     * @throws Exception
     */
    public function testSendMessage(): void {
      $this->createApiClient();
      //
      $_result = $this->_client->sendMessage('#iota.php', 'message test! follow me on Twitter @SourCL_Stefan');
      //
      $this->assertJson((string)$_result, 'client Info returned not a valid json');
      $this->assertIsArray((array)$_result, 'client Info returned not a valid array');
      //
      $this->assertArrayHasKey('messageId', (array)$_result, 'result need key "messageId"');

      $this->assertEquals(64, \strlen($_result->messageId), 'unknown length of messageId');
      $this->_lastMessageId = $_result->messageId;
    }

    /**
     * @throws Exception
     */
    public function testGetMessage(): void {
      $this->createApiClient();
      if(!$this->_lastMessageId) {
        $this->testSendMessage();
      }
      //
      $_result = $this->_client->getMessage($this->_lastMessageId);
      //
      $this->assertJson((string)$_result, 'client Info returned not a valid json');
      $this->assertIsArray((array)$_result, 'client Info returned not a valid array');
      //
      $this->assertArrayHasKey('payload', (array)$_result, 'result need key "payload"');
      $this->assertArrayHasKey('index', (array)$_result->payload, 'result need key "index"');
      $this->assertArrayHasKey('data', (array)$_result->payload, 'result need key "data"');

      var_dump((string)$_result->payload);
    }

    /**
     *
     */
    public function testFetchMessage(): void {
      $this->createApiClient();

      $_result = $this->_client->findMessage("#iota.php");
      //
      $this->assertJson((string)$_result, 'client Info returned not a valid json');
      $this->assertIsArray((array)$_result, 'client Info returned not a valid array');
      //
      $this->assertArrayHasKey('messageIds', (array)$_result, 'result need key "messageIds"');
      $this->assertArrayHasKey('count', (array)$_result, 'result need key "count"');
    }
  }
