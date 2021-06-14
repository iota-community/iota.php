<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // get milestone
  echo $milestone = $client->milestone($client->info()->latestMilestoneIndex);
  // print single informations
  #echo $milestone->messageId . LF;
  #echo $milestone->timestamp. LF;
  #echo $milestone->index. LF;
  // get milestone Message
  #echo $_client->message($milestone->messageId);