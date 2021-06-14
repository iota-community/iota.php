<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = iota::api('https://api.lb-0.testnet.chrysalis2.com');
  // Ed25519 Address
  $address = $client->utxo->addressEd25519("515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16");
  echo $address . LF;
  #echo $_address->balance . LF;

  // Bech32 Address
  $address = $client->utxo->addresses("atoi1qpg4tqh7vj9s7y9zk2smj8t4qgvse9um42l7apdkhw6syp5ju4w3vet6gtj");
  echo $address . LF;
  #echo $_address->balance . LF;

  # Result:
  #{"addressType":0,"address":"515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16","balance":10000000,"dustAllowed":false,"ledgerIndex":378166}
  #{"addressType":0,"address":"515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16","balance":10000000,"dustAllowed":false,"ledgerIndex":378166}