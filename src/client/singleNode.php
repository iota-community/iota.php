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
   * @return \iota\schemas\Message
   * @throws \Exception
   */
  public function message(string $messageId): \iota\schemas\Message {
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
}