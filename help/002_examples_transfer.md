![IOTA.php](./images/IOTA_PHP_Banner_Interact_Help.png)

<p style="text-align:center;">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>
  <a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>
  <a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA"></a>
  <a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square" alt=">PHP 8"></a>
  <img src="https://github.com/iota-community/iota.php/actions/workflows/phpunit.yml/badge.svg" alt="WorkflowUnitTest">
</p>

# Basics examples (Transfer)

### Include and create a client

```php
<?php
  // include iota lib
  require_once("autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
```

### Setup seedInput

```php
  $seedInput = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
```

or

```php
  $seedInput = "a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3";
```

### Send transfer

```php
   echo new IOTA\Action\sendTokens($seedInput, 0, "atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e", 1000000);
```

<hr>

### Get funds on testnet

Use [faucet client](./004_examples_faucet.md)

Or visit: https://faucet.testnet.chrysalis2.com/


<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)