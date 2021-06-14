<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  //
  $found = $client->findMessage('#iota.php');
  if(\count($found->messageIds) > 0) {
    echo "Messages Found: " . \count($found->messageIds) . LF;
    $lastData = $client->getMessagePayload(\end($found->messageIds));
    echo $lastData->data. LF;
  }
  else {
    echo "No Results!" . LF;
  }