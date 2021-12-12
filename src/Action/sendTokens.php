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
use IOTA\Helper\Amount;
use IOTA\Helper\Converter;
use IOTA\Models\AbstractAction;
use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseError;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;
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
   * @var Ed25519Seed
   */
  protected Ed25519Seed $ed25519Seed;
  /**
   * @var int
   */
  protected int $accountIndex = 0;
  /**
   * @var int
   */
  protected int $addressIndex = 0;
  /**
   * @var string|null
   */
  protected ?string $addressBech32 = null;
  /**
   * @var int|null
   */
  protected ?int $amount = 0;
  /**
   * @var PayloadIndexation
   */
  protected PayloadIndexation $indexation;

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   *
   * @return $this
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  public function seedInput(Ed25519Seed|Mnemonic|string|array $seedInput): self {
    $this->ed25519Seed = new Ed25519Seed($seedInput);

    return $this;
  }

  /**
   * @param int $accountIndex
   *
   * @return $this
   */
  public function accountIndex(int $accountIndex): self {
    $this->accountIndex = $accountIndex;

    return $this;
  }

  /**
   * @param int $addressIndex
   *
   * @return $this
   */
  public function addressIndex(int $addressIndex): self {
    $this->addressIndex = $addressIndex;

    return $this;
  }

  /**
   * @param string $addressBech32
   *
   * @return $this
   */
  public function toAddressBech32(string $addressBech32): self {
    $this->addressBech32 = $addressBech32;

    return $this;
  }

  /**
   * @param string $addressEd25519
   *
   * @return $this
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   */
  public function toAddressEd25519(string $addressEd25519): self {
    $this->addressBech32 = Converter::bech32ToEd25519($addressEd25519);

    return $this;
  }

  /**
   * @param string $index
   * @param string $data
   * @param bool   $_convertToHex
   *
   * @return $this
   */
  public function message(string $index = '', string $data = '', bool $_convertToHex = true): self {
    $this->indexation = new PayloadIndexation($index, $data, $_convertToHex);

    return $this;
  }

  /**
   * @param PayloadIndexation $indexation
   *
   * @return $this
   */
  public function payloadIndexation(PayloadIndexation $indexation): self {
    $this->indexation = $indexation;

    return $this;
  }

  /**
   * @param int|string|Amount $amount
   *
   * @return $this
   * @throws ExceptionHelper
   */
  public function amount(int|string|Amount $amount): self {
    $this->amount = (new Amount($amount))->getAmount();

    return $this;
  }

  /**
   * @return ResponseSubmitMessage|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function run(): ResponseSubmitMessage|ResponseError {
    $addressPath = new Bip32Path(("m/44'/4218'/0'/0'/0'"));
    $addressPath->setAccountIndex($this->accountIndex, true);
    $addressPath->setAddressIndex($this->addressIndex, true);
    $addressSeed = $this->ed25519Seed->generateSeedFromPath($addressPath);
    $address     = new Ed25519Address(($addressSeed->keyPair())->public);
    // get outputs
    $_outputs = $this->client->addressesed25519Output($address->toAddress());
    //
    // create essence
    $essenceTransaction = new EssenceTransaction();
    // add Indexation
    if(isset($this->indexation)) {
      $essenceTransaction->payload = $this->indexation;
    }
    // // parse outputs
    $_total = 0;
    foreach(($_outputs)->outputIds as $_id) {
      $_output = $this->client->output($_id);
      if(!$_output->isSpent && $this->amount > $_total) {
        $essenceTransaction->inputs[] = new Input(0, $_output->transactionId, $_output->outputIndex);
        $_total                       += $_output->output['amount'];
      }
    }
    if($_total == 0 || $_total < $this->amount) {
      $this->result = $returnValue = new ResponseError([
        'error'   => 901,
        'message' => "There are not enough funds in the inputs for the required balance! amount: $this->amount, balance: $_total",
      ]);
    }
    else {
      // transfer to new address
      $essenceTransaction->outputs[] = new Output(0, new Address(0, Converter::bech32toEd25519($this->addressBech32)), $this->amount);
      // sending remainder back, if amount not zero
      if($_total - $this->amount > 0) {
        $essenceTransaction->outputs[] = new Output(0, new Address(0, $address->toAddress()), ($_total - $this->amount));
      }
      // sort inputs / outputs
      sort($essenceTransaction->inputs);
      sort($essenceTransaction->outputs);
      //
      $payloadTransaction = new PayloadTransaction($essenceTransaction);
      // unlockBlocks
      $_list = [];
      foreach($essenceTransaction->inputs as $input) {
        $_publicKey = ($addressSeed->keyPair())->public;
        if(isset($_list[$_publicKey])) {
          $payloadTransaction->unlockBlocks[] = new UnlockBlocksReference($_list[$_publicKey]);
        }
        else {
          $payloadTransaction->unlockBlocks[] = new UnlockBlocksSignature(new Ed25519Signature($_publicKey, Ed25519::sign(($addressSeed->keyPair())->secret, $essenceTransaction->serializeToHash())));
          $_list[$_publicKey]                 = count($payloadTransaction->unlockBlocks) - 1;
        }
      }
      $this->result = $returnValue = $this->client->messageSubmit(new RequestSubmitMessage($payloadTransaction));
    }
    $this->callCallback($returnValue);

    return $this->result;
  }

  /**
   * @return ResponseSubmitMessage|ResponseError
   */
  public function getResult(): ResponseSubmitMessage|ResponseError {
    return parent::getResult();
  }
}