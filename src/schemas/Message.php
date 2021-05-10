<?php namespace iota\schemas;
/**
 * A message is the object nodes gossip around in the network. It always references two other messages that are known as parents. It is stored as a vertex on the tangle data structure that the nodes maintain. A message can have a maximum size of 32Kb.
 *
 * @package      iota\schemas\response
 */
class Message extends \iota\schemas\response\Message {
}