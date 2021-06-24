<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $client = new IOTA\Client\FaucetClient();
  echo $client->get('atoi1qpnknjkytwhj009uaucksr03azlz45c4nl5palf2hptsnn5m5hvt5kjllcp');