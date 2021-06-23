![IOTA.php](./images/header2.jpg)

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
<img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square" alt=">PHP 8">
</p>

# Basics examples (Client)

### Include and create a client
```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
```

### Getting client health
```php
  echo "Health: " . ($client->health() ? "ok" : "error");
```

### Getting client info
This example will output a json string
```php
  echo $client->info();
```
Each method returns an Object to get the direct parameter
```php
  $info = $client->info();

  echo $info->name;
  echo $info->version;
  echo $info->isHealthy;
  echo $info->networkId;
  echo $info->bech32HRP;
  echo $info->minPoWScore;
  echo $info->messagesPerSecond;
  echo $info->referencedMessagesPerSecond;
  echo $info->referencedRate;
  echo $info->latestMilestoneTimestamp;
  echo $info->latestMilestoneIndex;
  echo $info->confirmedMilestoneIndex;
  echo $info->pruningIndex;
  print_r($info->features);
```
Short example
```php
  echo ($client->info())->name;
```

### Getting tips
```php
  echo $client->tips();
```
<hr>

## Additional Examples
Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)