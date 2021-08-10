<?php
  // include iota lib
  require_once("../../autoload.php");
  // verify TangleMessage
  $result = \IOTA\Identity::verifyTangleMessage("1795ee882f61a51478723b5098ead9866ec4427ac1a4e74bc4a1e4d77c8e6a13");
  // output
  var_dump($result);