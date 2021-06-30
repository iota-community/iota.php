<?php
  // include iota lib
  require_once("../../autoload.php");
  // Open Wallet
  $wallet    = new \IOTA\Wallet('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  $address_0 = $wallet->address();
  // current balance
  echo "Balance address_0: " . $address_0->getBalance() . PHP_EOL;
  // send Tokens
  echo $address_0->send('atoi1qzvhzythy64dzx456ccvus357hvhg77cmqrrw4ukuszprtu9fay5ywp5ncz', 1000000) . PHP_EOL;
  // balance
  echo "Balance address_0: " . $address_0->getBalance() . PHP_EOL;