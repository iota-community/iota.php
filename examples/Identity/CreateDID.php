<?php
  // include iota lib
  require_once("../../autoload.php");
  // create DID
  $identity = new \IOTA\Identity(null, 'b8abd06270050caa6d2643868a22ae081aa446c4271b271f61a04873c4eba097f4ea23602dbb40c511038e3e31a902b2eaea0e45542854dd6dc526caacf26eb9');
  $DID      = $identity->create();
  // output
  var_dump($DID);