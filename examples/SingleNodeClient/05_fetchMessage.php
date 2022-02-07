<?php
  // include iota lib
  require_once("../../autoload.php");

  // create client
  $client = new \IOTA\Client\SingleNodeClient();
  // find Message
  $found = $client->messagesFind('#iota.php');
  if(count($found->messageIds) > 0) {
    echo "Messages Found: " . count($found->messageIds) . PHP_EOL;
    $lastData = $client->message(end($found->messageIds));

    $data = "unknown";

    if($lastData->payload instanceof \IOTA\Api\v1\ResponsePayloadTransaction) {
      $data = $lastData->payload->essence->payload->data;
    } else if($lastData->payload instanceof \IOTA\Api\v1\ResponsePayloadIndexation) {
      $data = $lastData->payload->data;
    }

    echo \IOTA\Helper\Converter::hex2String($data);

  }
  else {
    echo "No Results!" . PHP_EOL;
  }