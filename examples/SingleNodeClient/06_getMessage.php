<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  // print result of tangle tips
  echo $ret = $client->message('411cf3c0116faa9f00089a901d72573df508a17c06c29980b2125f9237a67971');