![IOTA.php](./images/header2.jpg)

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/SourCL_Stefan/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
<img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square" alt=">PHP 8">
</p>

# Examples (Faucet Client)

 Testnet tokens can only be used for testing within the chrysalis testnet
> Please do not claim tokens if you do not need them and return tokens you do not need. Testnet tokens have no value!

### Include and create a faucet client
```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota\client\faucet();
```

## get
```php
  echo $client->get('atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e');
```


## send
```php
  $seed           = iota::Ed25519Seed_fromMnemonic("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally");
  echo $client->send($seed, 0, 1000000, iota::createIndexation("#iota.php", "transaction faucet test! follow me on Twitter @SourCL_Stefan"));
```

---



<hr>

## Additional Examples
Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)