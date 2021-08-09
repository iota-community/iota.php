<?php
  // include iota lib
  require_once("../../autoload.php");
  // create DID
  $identity = new \IOTA\Identity();
  $DID      = $identity->create();
  // manipulate DID
  $manipulatedDID = $identity->manipulate($DID->document, $DID->messageId);
  // output
  var_dump($manipulatedDID);