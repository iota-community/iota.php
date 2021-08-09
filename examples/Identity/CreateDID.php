<?php
  // include iota lib
  require_once("../../autoload.php");
  // create DID
  $identity = new \IOTA\Identity();
  $DID      = $identity->create();
  // output
  var_dump($DID);