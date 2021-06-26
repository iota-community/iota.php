<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  // print result address Ed25519
  echo $ret = $client->addressEd25519('60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe');
  // print result address Bech32
  echo $ret = $client->address('atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e');