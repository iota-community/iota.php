<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\sendMessage;

  // create client
  $client = new SingleNodeClient();
  echo $ret = new sendMessage($client,'#iota.php', 'message test! follow me on Twitter @IOTAphp');