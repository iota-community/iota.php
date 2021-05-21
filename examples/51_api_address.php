<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  $utxo    = new \iota\api\utxo($_client);
  // Ed25519 Address
  $_address = $utxo->addressEd25519("515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16");
  echo $_address . LF;
  #echo $_address->balance . LF;

  // Bech32 Address
  $_address = $utxo->addresses("atoi1qpg4tqh7vj9s7y9zk2smj8t4qgvse9um42l7apdkhw6syp5ju4w3vet6gtj");
  echo $_address . LF;
  #echo $_address->balance . LF;