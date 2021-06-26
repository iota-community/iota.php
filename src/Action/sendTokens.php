<?php namespace IOTA\Action;

use IOTA\Api\v1\Address;
use IOTA\Api\v1\Ed25519Signature;
use IOTA\Api\v1\EssenceTransaction;
use IOTA\Api\v1\Input;
use IOTA\Api\v1\Output;
use IOTA\Api\v1\PayloadTransaction;
use IOTA\Api\v1\RequestSubmitMessage;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Api\v1\UnlockBlocksReference;
use IOTA\Api\v1\UnlockBlocksSignature;
use IOTA\Crypto\Bip32Path;
use IOTA\Crypto\Ed25519;
use IOTA\Crypto\Mnemonic;
use IOTA\Helper\Converter;
use IOTA\Models\AbstractAction;
use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseError;
use IOTA\Client\SingleNodeClient;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Action as ExceptionAction;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Exception\Type as ExceptionType;
use IOTA\Type\Ed25519Address;
use IOTA\Type\Ed25519Seed;
use SodiumException;


/**
 * Class sendTokens
 *
 * @package      IOTA\Action
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class sendTokens extends AbstractAction {
  /**
   * sendTokens constructor.
   *
   * @param SingleNodeClient                  $client
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param int                               $_accountIndex
   * @param string                            $addressBech32
   * @param int                               $amount
   * @param PayloadIndexation|null            $_indexation
   */
  public function __construct(protected SingleNodeClient $client, Ed25519Seed|Mnemonic|string|array $seedInput, int $_accountIndex, string $addressBech32, int $amount, ?PayloadIndexation $_indexation = null) {
    parent::__construct($client, $seedInput, $_accountIndex, $addressBech32, $amount, $_indexation);
  }

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param int                               $_accountIndex
   * @param string                            $addressBech32
   * @param int                               $amount
   * @param PayloadIndexation|null            $_indexation
   *
   * @return ResponseSubmitMessage|ResponseError
   * @throws ExceptionAction
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  protected function exec(Ed25519Seed|Mnemonic|string|array $seedInput = '', int $_accountIndex = 0, string $addressBech32 = '', int $amount = 0, ?PayloadIndexation $_indexation = null): ResponseSubmitMessage|ResponseError {
    $walletSeed = new Ed25519Seed($seedInput);
    //
    $addressPath = new Bip32Path(("m/44'/4218'/0'/0'/0'"));
    $addressPath->setAccountIndex($_accountIndex);
    $addressSeed = $walletSeed->generateSeedFromPath($addressPath);
    $address     = new Ed25519Address(($addressSeed->keyPair())['publicKey']);
    // get outputs
    $_outputs = $this->client->addressesed25519Output($address->toAddress());
    //
    // create essence
    $essenceTransaction = new EssenceTransaction();
    // add Indexation
    if($_indexation) {
      $essenceTransaction->payload = $_indexation;
    }
    // // parse outputs
    $_total = 0;
    foreach(($_outputs)->outputIds as $_id) {
      $_output = $this->client->output($_id);
      if(!$_output->isSpent && $amount > $_total) {
        $essenceTransaction->inputs[] = new Input(0, $_output->transactionId, $_output->outputIndex);
        $_total                       += $_output->output['amount'];
      }
    }
    if($_total == 0 || $_total < $amount) {
      throw new ExceptionAction("There are not enough funds in the inputs for the required balance! amount: $amount, balance: $_total");
    }
    // transfer to new address
    $essenceTransaction->outputs[] = new Output(0, new Address(0, Converter::bech32toEd25519($addressBech32)), $amount);
    // sending remainder back, if amount not zero
    if($_total - $amount > 0) {
      $essenceTransaction->outputs[] = new Output(0, new Address(0, $address->toAddress()), ($_total - $amount));
    }
    // sort inputs / outputs
    sort($essenceTransaction->inputs);
    sort($essenceTransaction->outputs);
    //
    $payloadTransaction = new PayloadTransaction($essenceTransaction);
    // unlockBlocks
    $_list = [];
    foreach($essenceTransaction->inputs as $input) {
      $_publicKey = ($addressSeed->keyPair())['publicKey'];
      if(isset($_list[$_publicKey])) {
        $payloadTransaction->unlockBlocks[] = new UnlockBlocksReference($_list[$_publicKey]);
      }
      else {
        $payloadTransaction->unlockBlocks[] = new UnlockBlocksSignature(new Ed25519Signature($_publicKey, Ed25519::sign(($addressSeed->keyPair())['privateKey'], $essenceTransaction->serializeToHash())));
        $_list[$_publicKey]                 = count($payloadTransaction->unlockBlocks) - 1;
      }
    }

    return $this->return = $this->client->messageSubmit(new RequestSubmitMessage($payloadTransaction));
  }

    /**
   * @return ResponseSubmitMessage|ResponseError
   */
  public function getReturn(): ResponseSubmitMessage|ResponseError {
    return $this->return;
  }
}