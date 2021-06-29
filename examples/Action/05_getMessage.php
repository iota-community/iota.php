<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\getMessage;

  // create client
  $client = new SingleNodeClient();
  //
  echo $ret = (new getMessage($client))->messageId("fcb61f2d45686c539c3437437b2c381cc1bc87959f8ef56cf51919ed86ed1676")
                                       ->run();