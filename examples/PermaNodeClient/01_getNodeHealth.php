<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\PermaNodeClient();

  // print result of node health
  echo "Health: " . ($client->health() ? "ok" : "error");