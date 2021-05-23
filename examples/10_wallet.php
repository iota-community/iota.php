<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $_client = new iota('https://api.lb-0.testnet.chrysalis2.com');

  // set mnemonic
  $words                 = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
  //
  $genesisSeed           = iota::Ed25519Seed_fromMnemonic($words);
  $genesisPath           = iota::Bip32Path("m/44'/4218'/0'/0'/0'");
  $genesisWalletSeed     = $genesisSeed->generateSeedFromPath($genesisPath);
  $genesisEd25519Address = iota::Ed25519Address(($genesisWalletSeed->keyPair())['publicKey']);
  //
  echo "#### genesisWallet ###############" . LF;
  echo "Seed: " . $genesisWalletSeed . LF;
  echo "Ed25519 Address: " . $genesisEd25519Address->toAddress() . LF;
  echo "Bech32 Address: " . $genesisEd25519Address->toBech32Adress(($_client->info())->bech32HRP) . LF;
  echo "##################################" . LF;
  //
  $walletSeed           = iota::Ed25519Seed("e57fb750f3a3a67969ece5bd9ae7eef5b2256a818b2aac458941f7274985a410");
  $walletPath           = iota::Bip32Path("m/44'/4218'/0'/0'/0'");
  $walletAddressSeed    = $walletSeed->generateSeedFromPath($walletPath);
  $walletEd25519Address = iota::Ed25519Address(($walletAddressSeed->keyPair())['publicKey']);
  //
  echo "### Wallet 1 #####################" . LF;
  echo "Seed: " . $walletSeed . LF;
  echo "Path: " . $walletPath . LF;
  echo "Ed25519 Address: " . $walletEd25519Address->toAddress() . LF;
  echo "Bech32 Address: " . $walletEd25519Address->toBech32Adress(($_client->info())->bech32HRP) . LF;
  echo "##################################" . LF;