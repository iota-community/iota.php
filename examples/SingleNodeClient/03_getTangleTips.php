<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  // print result of tangle tips
  echo $ret = $client->tips();
  // print single informations
  var_dump($ret->tipMessageIds);