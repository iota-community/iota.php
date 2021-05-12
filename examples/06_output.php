<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // get milestone
  echo $output = $_client->output("00000000000000000000000000000000000000000000000000000000000000000000");
  // print single informations
  #echo $output->messageId . LF;
  #echo $output->transactionId. LF;
  #echo $output->outputIndex. LF;
  #echo $output->isSpent. LF;
  #printr_($output->output);
  // get output Message
  #echo $_client->message($output->messageId);