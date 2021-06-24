<?php
  // include iota lib
  require_once("../../autoload.php");
  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\getBalance;

  // create client
  $client = new SingleNodeClient();

  // print result address Ed25519
  echo $ret = new getBalance($client,'515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16');
  // print result address Ed25519
  echo $ret = new getBalance($client,'atoi1qpg4tqh7vj9s7y9zk2smj8t4qgvse9um42l7apdkhw6syp5ju4w3vet6gtj');