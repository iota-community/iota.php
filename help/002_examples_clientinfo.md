<h2 align="center">iota.php</h2>

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?logo=discord" alt="Discord"></a>
    <img src="https://img.shields.io/badge/license-Apache--2.0-green" alt="Apache-2.0 license">
</p>

# Examples (Client info/health)

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

<hr>

## Additional Examples
Please find other examples in the [examples](../examples) folder.


<hr>

Back to [Overview](000_index.md)