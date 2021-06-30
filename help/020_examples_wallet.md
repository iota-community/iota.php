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

# Examples (Wallet)

### Include

```php
<?php
  // include iota lib
  require_once("autoload.php");
```

### Create new mnemonic

```php
  $mnemonic = new \IOTA\Crypto\Mnemonic(IOTA\Wallet::createMnemonic());
```

or

### Use exist mnemonic

```php
  $mnemonic = new \IOTA\Crypto\Mnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
```


### Open wallet

```php
  $wallet    = new \IOTA\Wallet($mnemonic);
```


### Open address

```php
  $address_0 = $wallet->address();
  $address_1 = $wallet->address(0, 1);
```



### Get informations

```php
  echo "WalletSeed:     " . $wallet->getSeed();
  echo "WalletMnemonic: " . $mnemonic;
```

```php
  echo "AddressPath:    " . $address_0->getPathString();
  echo "AddressBech32:  " . $address_0->getAddressBech32();
  echo "Balance:        " . $address_0->getBalance();

  echo "AddressPath:    " . $address_1->getPathString() . PHP_EOL;
  echo "AddressBech32:  " . $address_1->getAddressBech32() . PHP_EOL;
  echo "Balance:        " . $address_1->getBalance() . PHP_EOL;
```


---

## Additional Examples

Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)