<?php
  // include iota lib
  require_once("../../autoload.php");
  // create DID
  $identity = new \IOTA\Identity();
  $DID      = $identity->create();
  // set Service
  $service = new \IOTA\Identity\Service($DID->uri, 'LinkedDomains', 'test.IOTA.php');
  // manipulate DID
  $manipulatedDID = $identity->manipulate($DID->document, $DID->messageId, $service , new \IOTA\Util\Keys());
  // output
  var_dump($manipulatedDID);