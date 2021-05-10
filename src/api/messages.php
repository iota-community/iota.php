<?php namespace iota\api;
/**
 * Everything about messages.
 *
 * @package      iota\api
 */
class messages extends \iota\api {
  /**
   * Submit a message. The node takes care of missing* fields and tries to build the message. On success, the message will be stored in the Tangle. This endpoint will return the identifier of the built message. *The node will try to auto-fill the following fields in case they are missing: networkId, parentMessageIds, nonce. If payload is missing, the message will be built without a payload.
   *
   * @param \iota\schemas\payload | \iota\schemas\payload\Indexation $payload
   *
   * @return \iota\schemas\response\SubmitMessage
   * @throws \Exception
   */
  public function submit(\iota\schemas\request\SubmitMessage $message): \iota\schemas\response\SubmitMessage {

    return new \iota\schemas\response\SubmitMessage($this->_client->fetchArray("post", "messages", $message->__toJSON()));
  }

  /**
   * Search for messages matching a given indexation key.
   *
   * @param string $index
   *
   * @return \iota\schemas\response\MessagesFind
   */
  public function find(string $index): \iota\schemas\response\MessagesFind {
    return new \iota\schemas\response\MessagesFind($this->_client->fetchArray("get", "messages?index={$index}"));
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message.
   *
   * @param string $messageId
   *
   * @return \iota\schemas\Message
   * @throws \Exception
   */
  public function get(string $messageId): \iota\schemas\Message {
    return new \iota\schemas\Message($this->_client->fetchArray("get", "messages/{$messageId}"));
  }

  /**
   * Returns the metadata of a given message
   *
   * @param string $messageId
   *
   * @return \iota\schemas\response\MessageMetadata
   * @throws \Exception
   */
  public function getMetadata(string $messageId): \iota\schemas\response\MessageMetadata {
    return new \iota\schemas\response\MessageMetadata($this->_client->fetchArray("get", "messages/{$messageId}/metadata"));
  }

  /**
   * Returns the children of a message
   *
   * @param string $messageId
   *
   * @return \iota\schemas\response\MessageChildren
   */
  public function getChildren(string $messageId): \iota\schemas\response\MessageChildren {
    return new \iota\schemas\response\MessageChildren($this->_client->fetchArray("get", "messages/{$messageId}/children"));
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message raw data.
   * todo@st:create binary class
   *
   * @param string $messageId
   *
   * @return string binary
   */
  public function getRaw(string $messageId): string {
    return $this->_client->fetch("get", "messages/{$messageId}/raw");
  }
}