![IOTA.php](./images/header2.jpg)

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
<img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square" alt=">PHP 8">
</p>

# Examples (Basics)

### Include and create a client
```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
```

## Basics
Each methode with "echo" will return a json string
```php
  echo $client->info();
```
Each method returns an object to get the direct parameter
```php
  $info = $client->info();

  echo $info->name;
```
Short example
```php
  echo ($client->info())->name;
```

To work with an Array, you can user (array)
```php
  $array = (array)$client->info();
```

<hr>

## Additional Examples
Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)