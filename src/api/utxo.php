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
    return new \iota\schemas\response\Output($this->_client->fetchArray("get", "outputs/{$outputId}"));
  }

  /**
   * Get the balance of a bech32-encoded address.
   *
   * @param string $address bech32 encoded address
   *
   * @return \iota\schemas\response\BalanceAddress
   */
  public function addresses(string $address): \iota\schemas\response\BalanceAddress {
    return new \iota\schemas\response\BalanceAddress($this->_client->fetchArray("get", "addresses/{$address}"));
  }

  /**
   * Get the balance of a hex-encoded Ed25519 address
   *
   * @param string $address
   *
   * @return \iota\schemas\response\BalanceAddress
   * @throws \Exception
   */
  public function ed25519_adresses(string $address): \iota\schemas\response\BalanceAddress {
    return new \iota\schemas\response\BalanceAddress($this->_client->fetchArray("get", "addresses/ed25519/{$address}"));
  }

  /**
   * @param string $address      bech32-encoded address that is referenced by the outputs.
   * @param bool   $includeSpend Set to true to also include the known spent outputs for the given address.
   * @param int    $type         Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   *
   * @return \iota\schemas\response\OutputAddress
   */
  public function addressesOutput(string $address, bool $includeSpend = false, int $type = 0): \iota\schemas\response\OutputAddress {
    return new \iota\schemas\response\OutputAddress($this->_client->fetchArray("get", "addresses/{$address}/outputs?include-spent={$includeSpend}&type={$type}"));
  }

  /**
   * Get all outputs that use a given hex-encoded Ed25519 address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $address      hex-encoded Ed25519 address that is referenced by the outputs.
   * @param bool   $includeSpend Set to true to also include the known spent outputs for the given address.
   * @param int    $type         Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   *
   * @return \iota\schemas\response\OutputAddress
   */
  public function ed25519_addressesOutput(string $address, bool $includeSpend = false, int $type = 0): \iota\schemas\response\OutputAddress {
    return new \iota\schemas\response\OutputAddress($this->_client->fetchArray("get", "addresses/ed25519/{$address}/outputs?include-spent={$includeSpend}&type={$type}"));
  }
}