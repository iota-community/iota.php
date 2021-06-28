<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;

  // create client
  $client = new SingleNodeClient();
  // find Message
  $found = $client->messagesFind('#iota.php');
  if(count($found->messageIds) > 0) {
    echo "Messages Found: " . count($found->messageIds) . PHP_EOL;
    $lastData = $client->message(end($found->messageIds));
    echo $lastData->payload->data;
  }
  else {
    echo "No Results!" . PHP_EOL;
  }