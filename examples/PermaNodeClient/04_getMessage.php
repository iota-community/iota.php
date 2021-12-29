<?php
  // include iota lib
  require_once("../../autoload.php");

  // send Message to mainnet
  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\PayloadIndexation;

  // create SingleNodeClient
  $client = new SingleNodeClient('mainnet');
  // submit message
  echo $ret = $client->messageSubmit(new PayloadIndexation('#iota.php', 'message test! follow me on Twitter @IOTAphp'));

  // create PermaNodeClient
  $client = new \IOTA\Client\PermaNodeClient();

  // get message
  echo $client->message($ret->messageId) . PHP_EOL;

