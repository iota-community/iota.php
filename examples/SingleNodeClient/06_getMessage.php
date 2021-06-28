<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  // print result of tangle tips
  echo $ret = $client->message('c41b9bac7f8ec0e37b6e8e28bc0f6e2ce3024927889249323fda4a8a1fae0df5');