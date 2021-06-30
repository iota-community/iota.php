<?php
  // include iota lib
  require_once("../../autoload.php");
  // Open Wallet
  $wallet    = new \IOTA\Wallet('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  $address_0 = $wallet->address();
  $address_1 = $wallet->address(0, 1);
  $amount    = "1mi";
  // send Tokens
  echo "#--- send '$amount'" . PHP_EOL;
  echo "#    from: " . $address_0->getAddressBech32() . " | balance: " . $address_0->getBalance() . PHP_EOL;
  echo "#    to:   " . $address_1->getAddressBech32() . " | balance: " . $address_1->getBalance() . PHP_EOL;
  echo "#    result: " . $address_0->send($address_1->getAddressBech32(), $amount) . PHP_EOL;
  // send Tokens back ;-)
  echo "#--- send Tokens back" . PHP_EOL;
  echo "#    from:   " . $address_0->getAddressBech32() . " | balance: " . $address_0->getBalance() . PHP_EOL;
  echo "#    to:     " . $address_1->getAddressBech32() . " | balance: " . $address_1->getBalance() . PHP_EOL;
  echo "#    result: " . $address_1->send($address_0->getAddressBech32(), $amount) . PHP_EOL;
  // check balance
  echo "#--- check" . PHP_EOL;
  echo "#    Address 0: " . $address_0->getAddressBech32() . " | balance: " . $address_0->getBalance() . PHP_EOL;
  echo "#    Address 1: " . $address_1->getAddressBech32() . " | balance: " . $address_1->getBalance() . PHP_EOL;