<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  //
  echo $_result = $client->sendMessage(\iota\converter::strtohex('MY-DATA-INDEX'), \iota\converter::strtohex('IOTA, 🚀!'));
  //echo $_result->messageId;