<?php
  // include iota lib
  require_once("../../autoload.php");
  // create mnemonic
  #$mnemonic = IOTA\Wallet::createMnemonic();
  $mnemonic = new \IOTA\Crypto\Mnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  // Open Wallet
  $wallet    = new \IOTA\Wallet($mnemonic);
  $found = $wallet->searchAddresses(5,5, false);

  print_r($found);