<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota\client('https://api.lb-0.testnet.chrysalis2.com');
  // fetchStatus
  $_result = $_client->fetchStatus('get', '/health');
  // fetchJSON
  $_result = $_client->fetchJSON('get', 'info');
  // fetchArray
  $_result = $_client->fetchArray('get', 'info');
