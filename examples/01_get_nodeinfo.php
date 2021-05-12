<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // print result of node information
  echo "Health: " . ($client->health() ? "ok" : "error"). LF;
  // print result of node information
  echo $info = $client->info();
  // print single informations
  echo $info->name . LF;
  echo $info->version . LF;
  echo $info->isHealthy . LF;
  echo $info->networkId . LF;
  echo $info->bech32HRP . LF;
  echo $info->minPoWScore . LF;
  echo $info->messagesPerSecond . LF;
  echo $info->referencedMessagesPerSecond . LF;
  echo $info->referencedRate . LF;
  echo $info->latestMilestoneTimestamp . LF;
  echo $info->latestMilestoneIndex . LF;
  echo $info->confirmedMilestoneIndex . LF;
  echo $info->pruningIndex . LF;
  print_r($info->features); echo LF;
  // one line node information
  echo (new iota('https://api.lb-0.testnet.chrysalis2.com'))->info();