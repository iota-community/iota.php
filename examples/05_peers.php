<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // get peers
  $peers = $client->peers();
  $client->peers();
  #print_r($peers);