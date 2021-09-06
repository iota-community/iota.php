<?php
  // include iota lib
  require_once("../../autoload.php");
  // verify TangleMessage
  $result = \IOTA\Identity::verifyTangleMessage("30e10e1995b66d1be864a16b692b08b63d4e02eaa737f88d134d8678fd05b081");
  // output
  var_dump($result);