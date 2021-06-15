<?php declare(strict_types = 1);
  require_once("./iota.php");

  use PHPUnit\Framework\TestCase;

  /**
   * Class message
   */
  final class milestone extends TestCase {
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
     * @throws Exception
     */
    public function testSendMessage(): void {
      $this->createApiClient();
      //
      $_result = $this->_client->milestone((string)$this->_client->info()->latestMilestoneIndex);
      $this->assertJson((string)$_result, 'client Info returned not a valid json');
      $this->assertIsArray((array)$_result, 'client Info returned not a valid array');
      //
      $this->assertArrayHasKey('timestamp', (array)$_result, 'result need key "timestamp"');
      $this->assertArrayHasKey('index', (array)$_result, 'result need key "index"');
      $this->assertArrayHasKey('messageId', (array)$_result, 'result need key "messageId"');
    }
  }
