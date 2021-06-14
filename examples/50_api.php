<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = iota::api('https://api.lb-0.testnet.chrysalis2.com');
  // node
  $node = $client->node;
  #echo $node->info() . LF;
  #echo $node->health() . LF;
  // tangle
  $tangle = $client->tangle;
  #echo $_client->tangle->tips() . LF;
  // message
  $messages = $client->messages;
  #echo $messages->find((string) $index) . LF;
  #echo $messages->get((string)$messageId) . LF;
  #echo $messages->getMetadata((string)$messageId) . LF;
  #echo $messages->getChildren((string)$messageId);
  #echo $messages->getRaw((string)$messageId);
  #echo $messages->submit((\iota\schemas\request\SubmitMessage) $object);

  // milestones
  $milestones = $client->milestones;
  #echo $milestones->get((string) $index);
  #echo $milestones->utxoChanges((string) $index);


  // peers
  $peers = $client->peers;
  #echo $peers->get();
  #echo $peers->get((string) $peerId);

  // utxo
  $utxo = $client->utxo;
  #echo $utxo->find((string) $outputId);
  #echo $utxo->addressEd25519((string) $addressEd25519);
  #echo $utxo->addressesed25519Output((string) $addressEd25519);
  #echo $utxo->addresses((string) $addressBech32);
  #echo $utxo->addressesOutput((string) $addressBech32);
  #echo $utxo->treasury();