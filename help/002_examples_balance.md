![IOTA.php](./images/header2.jpg)

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/SourCL_Stefan/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
<img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square" alt=">PHP 8">
</p>

# Basics examples (Address)

### Include and create a client

```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
```

### Getting address info from bech32

```php
  echo $client->address("atoi1qpg4tqh7vj9s7y9zk2smj8t4qgvse9um42l7apdkhw6syp5ju4w3vet6gtj");
  #echo $_address->balance;
```

### Getting address info from ed25519

```php
  echo $client->addressEd25519("515582fe648b0f10a2b2a1b91d7502190c979baabfee85b6bbb5020692e55d16");
  #echo $_address->balance;
```

### Convert bech32 to ed25519

```php
  echo $client->bech32toEd25519("atoi1qpg4tqh7vj9s7y9zk2smj8t4qgvse9um42l7apdkhw6syp5ju4w3vet6gtj");
```

<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)