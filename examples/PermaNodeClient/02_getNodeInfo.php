<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\PermaNodeClient();

  // print result of node information
  echo $ret = $client->info();
  echo PHP_EOL;
  // print single informations
  echo $ret->name . PHP_EOL;
  echo $ret->version . PHP_EOL;
  echo $ret->isHealthy . PHP_EOL;