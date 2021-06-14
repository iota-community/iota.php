<?php namespace iota\client;
/**
 * Class singleNode
 *
 * @package iota\client
 */
class singleNode extends \iota\client {
  /**
   * @return \iota\schemas\response\Info
   */
  public function info(): \iota\schemas\response\Info {
    return (new \iota\api\node($this))->info();
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public function health(): bool {
    return (new \iota\api\node($this))->health();
  }

  /**
   * @return \iota\schemas\response\Tips
   */
  public function tips(): \iota\schemas\response\Tips {
    return (new \iota\api\tangle($this))->tips();
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message.
   *
   * @param string $messageId
   *
   * @return \iota\schemas\response\Message
   * @throws \Exception
   */
  public function message(string $messageId): \iota\schemas\response\Message {
    return (new \iota\api\messages($this))->get($messageId);
  }

  /**
   * Submit a message. The node takes care of missing* fields and tries to build the message. On success, the message will be stored in the Tangle. This endpoint will return the identifier of the built message. *The node will try to auto-fill the following fields in case they are missing: networkId, parentMessageIds, nonce. If payload is missing, the message will be built without a payload.
   *
   * @param $index
   * @param $data
   *
   * @return \iota\schemas\response\SubmitMessage
   * @throws \Exception
   */
  public function messageSubmit(\iota\schemas\request\SubmitMessage $message): \iota\schemas\response\SubmitMessage {
    return (new \iota\api\messages($this))->submit($message);
  }

  /**
   * Search for messages matching a given indexation key.
   *
   * @param string $index
   *
   * @return \iota\schemas\response\MessagesFind
   */
  public function messagesFind(string $index): \iota\schemas\response\MessagesFind {
    return (new \iota\api\messages($this))->find($index);
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message raw data.
   *
   * @param string $messageId
   *
   * @return string
   * @throws \Exception
   */
  public function messageRaw(string $messageId) {
    return (new \iota\api\messages($this))->getRaw($messageId);
  }

  /**
   * Returns the children of a message
   *
   * @param string $messageId
   *
   * @return \iota\schemas\response\MessageChildren
   * @throws \Exception
   */
  public function messageChildren(string $messageId): \iota\schemas\response\MessageChildren {
    return (new \iota\api\messages($this))->getChildren($messageId);
  }

  /**
   * Look up a milestone by a given milestone index.
   *
   * @param string $index
   *
   * @return \iota\schemas\response\Milestone
   */
  public function milestone(string $index): \iota\schemas\response\Milestone {
    return (new \iota\api\milestones($this))->get($index);
  }

  /**
   * Get all UTXO changes of a given milestone
   *
   * @param string $index
   *
   * @return \iota\schemas\response\UTXOChanges
   */
  public function milestoneUtxoChanges(string $index): \iota\schemas\response\Milestone {
    return (new \iota\api\milestones($this))->utxoChanges($index);
  }

  /**
   * @return \iota\schemas\response\Peers
   */
  public function peers(): \iota\schemas\response\Peers {
    return (new \iota\api\peers($this))->list();
  }

  /**
   * @param $peerId
   *
   * @return \iota\schemas\response\Peer
   */
  public function peer($peerId): \iota\schemas\response\Peer {
    return (new \iota\api\peers($this))->get($peerId);
  }

  /**
   * Add a given peer to the node.
   *
   * @param string $multiAddress
   * @param string $alias
   *
   * @return \iota\schemas\response\AddPeer
   */
  public function peerAdd(string $multiAddress, string $alias = null): \iota\schemas\response\AddPeer {
    return (new \iota\api\peers($this))->add($multiAddress, $alias);
  }

  /**
   * Remove/disconnect a given peer.
   *
   * @param string $peerId
   *
   * @return string
   */
  public function peerDelete(string $peerId): void {
    (new \iota\api\peers($this))->delete($peerId);
  }

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return \iota\schemas\response\Output
   */
  public function output(string $outputId): \iota\schemas\response\Output {
    return (new \iota\api\utxo($this))->find($outputId);
  }

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return \iota\schemas\response\Output
   */
  public function address(string $addressBech32): \iota\schemas\response\BalanceAddress {
    return (new \iota\api\utxo($this))->addresses($addressBech32);
  }

  /**
   * @param string $addressBech32 bech32-encoded address that is referenced by the outputs.
   * @param int    $type          Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   * @param bool   $includeSpend  Set to true to also include the known spent outputs for the given address.
   *
   * @return \iota\schemas\response\OutputAddress
   */
  public function addressesOutput(string $addressBech32, int $type = 0, bool $includeSpend = false): \iota\schemas\response\OutputAddress {
    return (new \iota\api\utxo($this))->addressesOutput($addressBech32, $type, $includeSpend);
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
    return (new \iota\api\utxo($this))->addressEd25519($addressEd25519);
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
    return (new \iota\api\utxo($this))->addressesed25519Output($addressEd25519, $type, $includeSpend);
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
    return (new \iota\api\utxo($this))->receipts($migratedAt);
  }

  /**
   * Returns information about the treasury
   *
   * @return \iota\schemas\response\Receipts
   * @throws \Exception
   */
  public function treasury(): \iota\schemas\response\Treasury {
    return (new \iota\api\utxo($this))->treasury();
  }
}