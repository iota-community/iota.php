<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Action\getBalance;
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\ResponseBalanceAddress;

  /**
   * Class getBalanceTest
   *
   * @author       StefanBraun @tanglePHP
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class getBalanceTest extends TestCase {
    /**
     * @var string
     */
    protected string $addressBech32 = "atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e";
    /**
     * @var string
     */
    protected string $addressEd25519 = "60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe";
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
    public function testgetBalanceAddressBech32() {
      $ret = (new getBalance($this->client))->address($this->addressBech32);
      $this->assertInstanceOf(getBalance::class, $ret);
      $this->assertInstanceOf(ResponseBalanceAddress::class, $ret->getResult());
    }

    /**
     *
     */
    public function testgetBalanceAddressEd25519() {
      $ret = (new getBalance($this->client))->address($this->addressEd25519);
      $this->assertInstanceOf(getBalance::class, $ret);
      $this->assertInstanceOf(ResponseBalanceAddress::class, $ret->getResult());
    }
  }
