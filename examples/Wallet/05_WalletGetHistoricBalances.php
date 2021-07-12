<?php
  // include iota lib
  require_once("../../autoload.php");
  // create mnemonic
  #$mnemonic = IOTA\Wallet::createMnemonic();
  $mnemonic = new \IOTA\Crypto\Mnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  // Open Wallet
  $wallet    = new \IOTA\Wallet($mnemonic);
  $address_0 = $wallet->address();
  //
  print_r($address_0->getHistoricBalances());