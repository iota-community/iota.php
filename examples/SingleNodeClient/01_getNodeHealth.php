<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  #$client = new IOTA\Client\SingleNodeClient('mainnet');

  // print result of node health
  echo "Health: " . ($client->health() ? "ok" : "error");