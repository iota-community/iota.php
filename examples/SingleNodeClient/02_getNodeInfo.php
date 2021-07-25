<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  #$client = new IOTA\Client\SingleNodeClient('mainnet');

  // print result of node information
  echo $ret = $client->info();
  // print single informations
  echo $ret->name . PHP_EOL;
  echo $ret->version . PHP_EOL;
  echo $ret->isHealthy . PHP_EOL;
  echo $ret->networkId . PHP_EOL;
  echo $ret->bech32HRP . PHP_EOL;
  echo $ret->minPoWScore . PHP_EOL;
  echo $ret->messagesPerSecond . PHP_EOL;
  echo $ret->referencedMessagesPerSecond . PHP_EOL;
  echo $ret->referencedRate . PHP_EOL;
  echo $ret->latestMilestoneTimestamp . PHP_EOL;
  echo $ret->latestMilestoneIndex . PHP_EOL;
  echo $ret->confirmedMilestoneIndex . PHP_EOL;
  echo $ret->pruningIndex . PHP_EOL;
  print_r($ret->features);