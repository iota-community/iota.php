<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;

  // create client
  $client = new SingleNodeClient();
  //
  echo $ret = $client->treasury($client->info()->latestMilestoneIndex);