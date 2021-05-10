<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota('https://api.lb-0.testnet.chrysalis2.com', [
    'user' => 'admin',
    'pass' => 'password',
  ]);
  // get peers
  $peers = $_client->peers('get', 'peers');