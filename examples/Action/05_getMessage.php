<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\getMessage;

  // create client
  $client = new SingleNodeClient();
  //
  echo $ret = (new getMessage($client))->messageId("7633345d8eaf3baf0178d1ce7ec8bcf0262cd83bc1bbdfc96dc5aa2085bd5569")
                                       ->run();