<?php
  // include iota lib
  require_once("../../autoload.php");

  use IOTA\Client\SingleNodeClient;
  use IOTA\Action\sendTokens;
  use IOTA\Action\checkTransaction;

  // create client
  $client = new SingleNodeClient();
  #$client = new SingleNodeClient('mainnet');
  //
  $mnemonicWords = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
  $amount        = "1mi";
  $toAddress     = 'atoi1qzvhzythy64dzx456ccvus357hvhg77cmqrrw4ukuszprtu9fay5ywp5ncz';
  $message       = 'transaction test! follow me on Twitter @tanglePHP';
  //
  $transactionRes = (new sendTokens($client))->amount($amount)
                                             ->seedInput($mnemonicWords)
                                             ->toAddressBech32($toAddress)
                                             ->message("#tanglePHP", $message)
                                             ->run();
  //
  // Check transaction
  if(isset($transactionRes->messageId)) {
    $checkTransaction = (new checkTransaction($client))->messageId($transactionRes->messageId)
                                                       ->run();
    // response have to be "included"
    if($checkTransaction != "included") {
      die ('transactionError: ' . $checkTransaction);
    }
  }
  else {
    die ('no Transaction: ' . $transactionRes->message);
  }
  // print info
  echo $transactionRes->messageId . " : " .$checkTransaction . PHP_EOL;
  //  print explorer link
  echo $client->network->EXPLORER . "message/". $transactionRes->messageId;
