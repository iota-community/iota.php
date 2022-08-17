<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $builder = new IOTA\Builder();
  #$builder->client('SingleNodeClient', 'devnet');
  // send message
  $builder->sendMessage('MessageTransfare1')
          ->index('#tanglePHP')
          ->data('message test! follow me on Twitter @tanglePHP')
          ->convertToHex(true);
  // sendToken
  $builder->sendTokens('TokenTansfare1')
          ->amount(1000000)
          ->seedInput("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally")
          ->toAddressBech32('atoi1qzvhzythy64dzx456ccvus357hvhg77cmqrrw4ukuszprtu9fay5ywp5ncz')
          ->message('#tanglePHP', 'transaction test! follow me on Twitter @tanglePHP');
  //
  $builder->getBalance('AddressBalance1')
          ->address("atoi1qzvhzythy64dzx456ccvus357hvhg77cmqrrw4ukuszprtu9fay5ywp5ncz");

  // run all
  $_run = $builder->run();
  // print result
  print_r($_run);
