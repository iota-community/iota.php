<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Action\sendTokens;
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\ResponseSubmitMessage;
  use IOTA\Api\v1\PayloadIndexation;
  use IOTA\Exception\Action as ExceptionAction;

  /**
   * Class sendMessageTest
   *
   * @author       StefanBraun @tanglePHP
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class sendTokensTest extends TestCase {
    /**
     * @var string
     */
    protected string $mnemonic = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
    /**
     * @var string
     */
    protected string $addressBech32 = "atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e";
    /**
     * @var string
     */
    protected string $toAddressBech32 = "atoi1qzvhzythy64dzx456ccvus357hvhg77cmqrrw4ukuszprtu9fay5ywp5ncz";
    /**
     * @var string
     */
    protected string $index = "#tanglePHP";
    /**
     * @var string
     */
    protected string $message = "message test! follow me on Twitter @tanglePHP";
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
     * @var int
     */
    private $getFundsCount = 0;

    /**
     * @throws \IOTA\Exception\Api
     * @throws \IOTA\Exception\Helper
     */
    private function getFunds(): void {
      (new \IOTA\Client\FaucetClient())->get($this->addressBech32);
    }

    /**
     *
     */
    public function testsendTokens(?PayloadIndexation $indexation = null): void {
      try {
        $ret = (new sendTokens($this->client))->amount(1000000)
                                              ->seedInput($this->mnemonic)
                                              ->toAddressBech32($this->toAddressBech32);
        if($indexation) {
          $ret->payloadIndexation($indexation);
        }
        $this->assertInstanceOf(sendTokens::class, $ret);

        if($ret->getResult() instanceof \IOTA\Api\v1\ResponseError) {
          throw new ExceptionAction($ret->getResult()->message);
        } else {
          $this->assertInstanceOf(ResponseSubmitMessage::class, $ret->getResult());
        }
      }
      catch(ExceptionAction $e) {
        if($e->getMessage() == "There are not enough funds in the inputs for the required balance! amount: 1000000, balance: 0") {
          if($this->getFundsCount <= 2) {
            $this->getFundsCount++;
            $this->getFunds();
            sleep(8);
            $this->testsendTokens($indexation);
          }
          else {
            $this->getFundsCount = 0;
            $this->assertTrue(true);
          }

          return;
        }
        throw new Exception($e->getMessage());
      }
    }

    /**
     * @throws Exception
     */
    public function testsendTokensWithIndexation(): void {
      $this->testsendTokens(new PayloadIndexation($this->index, $this->message));
    }
  }
