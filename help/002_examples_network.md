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

# Examples (Network)

### Include the library
```php
<?php
  // include iota lib
  require_once("autoload.php");
```

## Connect to testnet
The standard network connection is "testnet"
```php
  // create client
  $client = new IOTA\Client\SingleNodeClient();
  // or
  $client = new IOTA\Client\SingleNodeClient('testnet');
  // or
  $client = new IOTA\Client\SingleNodeClient('https://api.lb-0.testnet.chrysalis2.com');
```

## Connect to mainnet

> Please be aware that this library is in an early development state and the API of the library as well as the IOTA protocol is subject to change, it is NOT ready to use in production.

Switch network connection to "mainnet"
```php
  // create client
  $client = new IOTA\Client\SingleNodeClient('mainnet');
  // or
  $client = new IOTA\Client\SingleNodeClient('chrysalis-nodes.iota.org');
```

---

## Additional Examples
Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)