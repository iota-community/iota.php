<?php
  // include iota lib
  require_once("../../autoload.php");
  // create client
  $builder = new IOTA\Builder();
  // sendToken
  $builder->sendTokens()
          ->amount(1000000)
          ->seedInput("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally")
          ->toAddressBech32('atoi1qzvhzythy64dzx456ccvus357hvhg77cmqrrw4ukuszprtu9fay5ywp5ncz')
          ->message('#iota.php', 'transaction test! follow me on Twitter @IOTAphp')
          ->callback('responseCheckTransaction');

  $builder->run();



  /**
   * @param $response
   *
   * @throws \IOTA\Exception\Api
   * @throws \IOTA\Exception\Helper
   */
  function responseCheckTransaction($response) {
    global $builder;
    if($response instanceof \IOTA\Api\v1\ResponseSubmitMessage) {
      $ret = $builder->checkTransaction()
                     ->messageId($response->messageId)
                     ->run();
      echo $ret == "included" ? "OK!" : $ret;
    }
    else {
      echo $response->message;
    }
  }