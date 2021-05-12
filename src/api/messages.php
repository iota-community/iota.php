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
    return $this->fetch([
      'method'      => 'post',
      'route'       => "messages",
      'requestData' => $message->__toJSON(),
      'return'      => \iota\schemas\response\SubmitMessage::class,
    ]);
  }

  /**
   * Search for messages matching a given indexation key.
   *
   * @param string $index
   *
   * @return \iota\schemas\response\MessagesFind
   */
  public function find(string $index): \iota\schemas\response\MessagesFind {
    return $this->fetch([
      'route'  => "messages",
      'query'  => ['index' => $index],
      'return' => \iota\schemas\response\MessagesFind::class,
    ]);
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message.
   *
   * @param string $messageId
   *
   * @return \iota\schemas\response\Message
   * @throws \Exception
   */
  public function get(string $messageId): \iota\schemas\response\Message {
    return $this->fetch([
      'route'  => "messages/{$messageId}",
      'return' => \iota\schemas\response\Message::class,
    ]);
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
    return $this->fetch([
      'route'  => "messages/{$messageId}/metadata",
      'return' => \iota\schemas\response\MessageMetadata::class,
    ]);
  }

  /**
   * Returns the children of a message
   *
   * @param string $messageId
   *
   * @return \iota\schemas\response\MessageChildren
   */
  public function getChildren(string $messageId): \iota\schemas\response\MessageChildren {
    return $this->fetch([
      'route'  => "messages/{$messageId}/children",
      'return' => \iota\schemas\response\MessageChildren::class,
    ]);
  }

  /**
   * Find a message by its identifer. This endpoint returns the given message raw data.
   * todo@st:create binary fetch
   *
   * @param string $messageId
   *
   * @return string binary
   */
  public function getRaw(string $messageId): string {
    return $this->fetch([
      'fetch' => 'Binary',
      'route' => "messages/{$messageId}/raw",
    ]);
  }
}