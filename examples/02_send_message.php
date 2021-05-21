<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // send Message
  echo $_result = $client->sendMessage(\iota\converter::bin2hex('MY-DATA-INDEX'), \iota\converter::bin2hex('IOTA, 🚀!'));
  //echo $_result->messageId;