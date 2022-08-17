![tanglePHP](./images/IOTA_PHP_Banner_Interact_Help.png)

<p style="text-align:center;">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/tanglePHP/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>
  <a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>
  <a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA"></a>
  <a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square&logo=php" alt=">PHP 8"></a>
  <img src="https://github.com/iota-community/iota.php/actions/workflows/phpunit.yml/badge.svg" alt="WorkflowUnitTest">
  <a href="https://packagist.org/packages/iota-community/iota.php/" style="text-decoration:none;"><img src="https://poser.pugx.org/iota-community/iota.php/v/stable.png" alt=">packagist_stable"></a>
</p>

# Examples (API)

### Include and create a SingleNodeClient
```php
<?php
  // include iota lib
  require_once("autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
```

## node
```php
  echo $client->info();
  echo $client->health();
```
## tangle
```php
  echo $client->tips() . LF;
```
## messages
```php
  echo $client->message((string)$messageId);
  echo $client->messagesFind((string) $index);
  echo $client->messageMetadata((string)$messageId);
  echo $client->messageChildren((string)$messageId);
  echo $client->messagesRaw((string)$messageId);
  echo $client->messageSubmit((\IOTA\Api\v1\RequestSubmitMessage) $object);
```
## milestones
```php
  echo $client->milestone((string) $index);
  echo $client->milestoneUtxoChanges((string) $index);
```
## peers
```php
  echo $client->peers();
  echo $client->peer((string) $peerId);
```
## utxo
```php
  echo $client->output((string) $outputId);  
  echo $client->addresses((string) $addressBech32);
  echo $client->addressesOutput((string) $addressBech32);
  echo $client->addressEd25519((string) $addressEd25519);
  echo $client->addressesed25519Output((string) $addressEd25519);
  echo $client->receipts();
  echo $client->treasury();
```

<hr>

## Additional Examples
Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)