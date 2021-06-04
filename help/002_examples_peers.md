<h2 align="center">iota.php</h2>

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/SourCL_Stefan/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
</p>

# Examples (Peers)

### Include and create a client

```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
```

### Get peers list

```php
  $result = $client->peers();
  #print_r($result);
```

### Get pear

```php
  echo $client->peer((string) $peerId);
```

<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


<hr>

Back to [Overview](000_index.md)