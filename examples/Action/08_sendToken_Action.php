<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\sendTokens;
  use IOTA\Api\v1\PayloadIndexation;

  // create client
  $client = new SingleNodeClient();
  //
  $mnemonicWords = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
  $seed          = "a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3";
  //
  $Indexation = new PayloadIndexation("#iota.php", "transaction test! follow me on Twitter @IOTAphp");
  //
  echo $ret = new sendTokens($client, $mnemonicWords, 0, 'atoi1qpnknjkytwhj009uaucksr03azlz45c4nl5palf2hptsnn5m5hvt5kjllcp', 1000000, $Indexation);
  
