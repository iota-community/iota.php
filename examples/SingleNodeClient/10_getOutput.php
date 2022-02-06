<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;

  // create client
  $client = new SingleNodeClient();
  //
  echo $ret = $client->addressesed25519Output("8ee057f3d427a3dd88704a3569ae8e76dfa3dd5bf635eee2f3ca273b0660435d");