<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\PayloadIndexation;

  // create client
  $client = new SingleNodeClient();
  // submit Message
  echo $ret = $client->messageSubmit(new PayloadIndexation('#tanglePHP', 'message test! follow me on Twitter @tanglePHP'));
