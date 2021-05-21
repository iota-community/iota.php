<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // node
  $node = new \iota\api\node($_client);
  // tangle
  $tangle = new \iota\api\tangle($_client);
  // milestones
  $milestones = new \iota\api\milestones($_client);
  // peers
  $peers = new \iota\api\peers($_client);
  // utxo
  $utxo = new \iota\api\utxo($_client);