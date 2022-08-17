<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\PermaNodeClient;
  use IOTA\Helper\Converter;

  // create client
  $client = new PermaNodeClient();
  // find Message
  $found = $client->messagesFind('#tanglePHP');
  if(count($found->messageIds) > 0) {
    echo "Messages Found: " . count($found->messageIds) . PHP_EOL;
    $lastData = $client->message(end($found->messageIds));
    echo Converter::hex2String($lastData->payload->data);
  }
  else {
    echo "No Results!" . PHP_EOL;
  }