<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota\client\faucet();
  echo $client->get('atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e');