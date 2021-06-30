<?php
  // include iota lib
  require_once("../../autoload.php");
  // create mnemonic
  #$mnemonic = IOTA\Wallet::createMnemonic();
  $mnemonic = new \IOTA\Crypto\Mnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  // Open Wallet
  $wallet    = new \IOTA\Wallet($mnemonic);
  $address_0 = $wallet->address();
  $address_1 = $wallet->address(0, 1);
  // outputs
  echo "WalletSeed: " . $wallet->getSeed() . PHP_EOL;
  echo "WalletMnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;
  echo "Address 0" . PHP_EOL;
  echo "AddressPath: " . $address_0->getPathString() . PHP_EOL;
  echo "AddressBech32: " . $address_0->getAddressBech32() . PHP_EOL;
  echo "Balance: " . $address_0->getBalance() . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;
  echo "Address 1" . PHP_EOL;
  echo "AddressPath: " . $address_1->getPathString() . PHP_EOL;
  echo "AddressBech32: " . $address_1->getAddressBech32() . PHP_EOL;
  echo "Balance: " . $address_1->getBalance() . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;