<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // send Message
  echo $result = $client->sendMessage('#iota.php', 'message test! follow me on Twitter @IOTAphp');
  #echo $result->messageId;