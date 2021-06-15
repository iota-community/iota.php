<?php namespace iota\api;
/**
 * Everything about UTXOs.
 *
 * @package      iota\api
 */
class utxo extends \iota\api {
  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return \iota\schemas\response\Output
   */
  public function find(string $outputId): \iota\schemas\response\Output {
    return $this->fetch([
      'route'  => "outputs/{$outputId}",
      'return' => \iota\schemas\response\Output::class,
    ]);
  }

  /**
   * Get the balance of a bech32-encoded address.
   *
   * @param string $addressBech32 bech32 encoded address
   *
   * @return \iota\schemas\response\BalanceAddress
   */
  public function addresses(string $addressBech32): \iota\schemas\response\BalanceAddress {
    return $this->fetch([
      'route'  => "addresses/{$addressBech32}",
      'return' => \iota\schemas\response\BalanceAddress::class,
    ]);
  }

  /**
   * Get all outputs that use a given bech32-encoded address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressBech32 bech32-encoded address that is referenced by the outputs.
   * @param int    $type          Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   * @param bool   $includeSpend  Set to true to also include the known spent outputs for the given address.
   *
   * @return \iota\schemas\response\OutputAddress
   */
  public function addressesOutput(string $addressBech32, int $type = 0, bool $includeSpend = false): \iota\schemas\response\OutputAddress {
    return $this->fetch([
      'route'  => "addresses/{$addressBech32}/outputs",
      'query'  => [
        'include-spent' => $includeSpend,
        'type'          => $type,
      ],
      'return' => \iota\schemas\response\OutputAddress::class,
    ]);
  }

  /**
   * Get the balance of a hex-encoded Ed25519 address
   *
   * @param string $addressEd25519
   *
   * @return \iota\schemas\response\BalanceAddress
   * @throws \Exception
   */
  public function addressEd25519(string $addressEd25519): \iota\schemas\response\BalanceAddress {
    return $this->fetch([
      'route'  => "addresses/ed25519/{$addressEd25519}",
      'return' => \iota\schemas\response\BalanceAddress::class,
    ]);
  }

  /**
   * Get all outputs that use a given hex-encoded Ed25519 address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressEd25519 hex-encoded Ed25519 address that is referenced by the outputs.
   * @param int    $type           Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   * @param bool   $includeSpend   Set to true to also include the known spent outputs for the given address.
   *
   * @return \iota\schemas\response\OutputAddress
   */
  public function addressesed25519Output(string $addressEd25519, int $type = 0, bool $includeSpend = false): \iota\schemas\response\OutputAddress {
    return $this->fetch([
      'route'  => "addresses/ed25519/{$addressEd25519}/outputs",
      'query'  => [
        'include-spent' => $includeSpend,
        'type'          => $type,
      ],
      'return' => \iota\schemas\response\OutputAddress::class,
    ]);
  }

  /**
   * Get all the stored receipts or those for a given migrated at index.
   *
   * @param int|null $migratedAt
   *
   * @return \iota\schemas\response\Receipts
   * @throws \Exception
   */
  public function receipts(int $migratedAt = null): \iota\schemas\response\Receipts {
    return $this->fetch([
      'route'  => "receipts" . ($migratedAt ? "/{$migratedAt}" : ''),
      'return' => \iota\schemas\response\Receipts::class,
    ]);
  }

  /**
   * Returns information about the treasury
   *
   * @return \iota\schemas\response\Treasury
   * @throws \Exception
   */
  public function treasury(): \iota\schemas\response\Treasury {
    return $this->fetch([
      'route'  => "addresses/treasury",
      'return' => \iota\schemas\response\Treasury::class,
    ]);
  }
}