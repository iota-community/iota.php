<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\PermaNodeClient;

  // create client
  $client = new PermaNodeClient();
  //
  echo $ret = $client->milestone("704379");