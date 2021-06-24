<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\FaucetClient();
  //
  $mnemonicWords = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
  //
  echo $client->send($mnemonicWords, 0, 1000000);