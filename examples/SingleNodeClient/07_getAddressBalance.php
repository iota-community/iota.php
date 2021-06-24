<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  // print result address Ed25519
  echo $ret = $client->addressEd25519('515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16');
  // print result address Bech32
  echo $ret = $client->address('atoi1qpg4tqh7vj9s7y9zk2smj8t4qgvse9um42l7apdkhw6syp5ju4w3vet6gtj');