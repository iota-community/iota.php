<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\sendMessage;

  // create client
  $client = new SingleNodeClient();
  echo $ret = (new sendMessage($client))->index('#tanglePHP')
                                        ->data('message test! follow me on Twitter @tanglePHP')
                                        ->run();