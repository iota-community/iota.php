<?php declare(strict_types = 1);
  require_once("./iota.php");

  use PHPUnit\Framework\TestCase;

  /**
   * Class node
   */
  final class node extends TestCase {
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
     *
     */
    public function testNodeHealth(): void {
      $this->createApiClient();
      $this->assertTrue($this->_client->health(), 'Health not OK');
    }

    /**
     *
     */
    public function testNodeInfo(): void {
      $this->createApiClient();
      $_result = $this->_client->info();
      $this->assertJson((string)$_result, 'client Info returned not a valid json');
      $this->assertIsArray((array)$_result, 'client Info returned not a valid array');
      $this->assertArrayHasKey('name', (array)$_result, 'result need key "name"');
      $this->assertArrayHasKey('version', (array)$_result, 'result need key "version"');
      $this->assertArrayHasKey('isHealthy', (array)$_result, 'result need key "isHealthy"');
      $this->assertArrayHasKey('networkId', (array)$_result, 'result need key "networkId"');
      $this->assertArrayHasKey('bech32HRP', (array)$_result, 'result need key "bech32HRP"');
    }

    /**
     * @throws Exception
     */
    public function testTangleApi(): void {
      $this->createApiClient();
      $this->assertTrue($this->_client->health(), 'Health not OK');
      //
      $_result = $this->_client->tips();
      $this->assertJson((string)$_result, 'client returned not a valid json');
      $this->assertIsArray((array)$_result, 'client returned not a valid array');
      $this->assertArrayHasKey('tipMessageIds', (array)$_result, 'result need key "tipMessageIds"');
    }
  }
