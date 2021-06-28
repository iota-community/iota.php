<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\getBalance;

  // create client
  $client = new SingleNodeClient();
  // print result address Ed25519
  echo $ret = (new getBalance($client))->address('60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe')
                                       ->run();
  // print result address Bech32
  echo $ret = (new getBalance($client))->address('atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e')
                                       ->run();