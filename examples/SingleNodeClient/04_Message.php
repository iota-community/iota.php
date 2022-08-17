<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Api\v1\PayloadIndexation;

  // create client
  $client = new SingleNodeClient();
  // submit message
  echo $ret = $client->messageSubmit(new PayloadIndexation('#tanglePHP', 'message test! follow me on Twitter @tanglePHP'));
  // get raw message
  echo $client->messageRaw($ret->messageId) . PHP_EOL;
  // get children of message
  echo $client->messageChildren($ret->messageId) . PHP_EOL;
  // get metadata of message
  echo $client->messageMetadata($ret->messageId) . PHP_EOL;

