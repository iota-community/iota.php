<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota\client\api('https://api.lb-0.testnet.chrysalis2.com');
  // node
  $node = $_client->node;
  #echo $_client->node->info() . LF;
  #echo $_client->node->health() . LF;
  // tangle
  $tangle = $_client->tangle;
  #echo $_client->tangle->tips() . LF;
  // message
  $tangle = $_client->messages;
  // milestones
  $milestones = $_client->milestones;
  // peers
  $peers = $_client->peers;
  // utxo
  $utxo = $_client->utxo;