<?php namespace IOTA\Wallet;

use IOTA\Api\v1\PayloadIndexation;
use IOTA\Api\v1\ResponseError;
use IOTA\Helper\Amount;
use IOTA\Wallet;
use IOTA\Action\checkTransaction;
use IOTA\Action\sendTokens;
use IOTA\Type\Ed25519Address;
use IOTA\Crypto\Bip32Path;
use IOTA\Exception\Converter as ExceptionConverter;
use IOTA\Exception\Crypto as ExceptionCrypto;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Type as ExceptionType;
use IOTA\Exception\Api as ExceptionApi;
use SodiumException;

/**
 * Class Address
 *
 * @package      IOTA\Wallet
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Address {
  /**
   * @var Bip32Path
   */
  protected Bip32Path $path;
  /**
   * @var Ed25519Address
   */
  protected Ed25519Address $address;

  /**
   * Address constructor.
   *
   * @param Wallet $wallet
   * @param int    $accountIndex
   * @param int    $addressIndex
   * @param bool   $isInternal
   *
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function __construct(protected Wallet $wallet, int $accountIndex = 0, int $addressIndex = 0, bool $isInternal = false) {
    $this->path = new Bip32Path("m/44'/4218'/0'/0'/0'");
    $this->path->setAccountIndex($accountIndex, true);
    $this->path->setAddressIndex($addressIndex, true);
    $this->path->setChange($isInternal ? 1 : 0, true);
    //
    $_addressSeed  = $wallet->getSeed()
                            ->generateSeedFromPath($this->path);
    $this->address = new Ed25519Address(($_addressSeed->keyPair())['publicKey']);
  }

  /**
   * @return string
   */
  public function getPathString(): string {
    return (string)$this->path;
  }

  /**
   * @return int
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getBalance(): int {
    return ($this->wallet->client->address($this->address->toAddressBetch32($this->wallet->bech32HRP)))->balance;
  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function getAddress(): string {
    return $this->address->toAddress();
  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function getAddressBech32(): string {
    return $this->address->toAddressBetch32($this->wallet->bech32HRP);
  }

  /**
   * @param string                 $toAddressBech32
   * @param int|string|Amount      $amount
   * @param PayloadIndexation|null $indexation
   * @param bool                   $checkTransaction
   *
   * @return string
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function send(string $toAddressBech32, int|string|Amount $amount, ?PayloadIndexation $indexation = null, bool $checkTransaction = true): string {
    // build Action\sendTokens
    $send = (new sendTokens($this->wallet->client))->amount($amount)
                                                   ->seedInput($this->wallet->getSeed())
                                                   ->accountIndex((int)$this->path->getAccountIndex())
                                                   ->addressIndex((int)$this->path->getAddressIndex())
                                                   ->toAddressBech32($toAddressBech32);
    // PayloadIndexation
    $indexation ? $send->payloadIndexation($indexation) : $send->message("#iota.php", "wallet address transaction test! follow me on Twitter @IOTAphp");
    // run and check
    $send = $send->run();
    if($send instanceof ResponseError) {
      return "error:" . $send->message;
    }
    // build Action\checkTransaction
    if($checkTransaction) {
      return $send->messageId . ":" . (new checkTransaction($this->wallet->client))->messageId($send->messageId)
                                                                                   ->run();
    }

    return $send->messageId;
  }

  /**
   * @return array
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function __toArray(): array {
    return [
      'path'           => $this->getPathString(),
      'addressEd25519' => $this->getAddress(),
      'addressBech32'  => $this->getAddressBech32(),
      'balance'        => $this->getBalance(),
    ];
  }
}