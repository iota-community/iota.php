<?php
  // include iota lib
  require_once("../../autoload.php");
  // verify TangleMessage
  $result = \IOTA\Identity::verifyTangleMessage("a593cb3216a7571f2fa92065860c0e7da45ce8cbea3760084c45382a4d5cc5cc");
  // output
  var_dump($result);