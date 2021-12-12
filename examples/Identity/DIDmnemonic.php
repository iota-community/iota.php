<?php
  // include iota lib
  require_once("../../autoload.php");
  //-------------------------------------------------------------------------
  // user mnemonic
  // $mnemonic = (new \IOTA\Crypto\Bip39())->reverseMnemonic("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally");
  $mnemonic = \IOTA\Builder::createRandomMnemonic();
  // create Ed25519 Seed
  $Ed25519Seed = \IOTA\Builder::createEd25519Seed($mnemonic);
  //-------------------------------------------------------------------------
  // service mnemonic
  // create Ed25519 Seed
  $Ed25519Seed_service = \IOTA\Builder::createEd25519Seed("empower essence pitch bid random dwarf toy gesture cheap garment paper void celery aim need crime tenant blush exhibit anxiety similar estate because silk");
  //-------------------------------------------------------------------------
  // create DID
  $identity = new \IOTA\Identity(null, $Ed25519Seed->keyPair());
  $DID      = $identity->create();
  // set Service
  $service = new \IOTA\Identity\Service($DID->uri, 'LinkedDomains', 'IOTA.php');
  // manipulate DID
  $manipulatedDID = $identity->manipulate($DID->document, $DID->messageId, $service, $Ed25519Seed_service->keyPair());
  // output
  var_dump($manipulatedDID);