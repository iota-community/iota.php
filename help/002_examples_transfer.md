<h2 align="center">iota.php</h2>

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?logo=discord" alt="Discord"></a>
    <img src="https://img.shields.io/badge/license-Apache--2.0-green" alt="Apache-2.0 license">
</p>

# Examples (Transfer)

### Include and create a client

```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
```

### Send transfer

```php
  $seed           = iota::Ed25519Seed_fromMnemonic("giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally");
  echo $client->send($seed, 0, "atoi1qpup0r22zvmlvptmsdaxtkycgpf6ak2ps2xwc94tmgnazzy0qj8l72pqmyx", 1000000, iota::createIndexation("#iota.php", "transaction test! follow me on Twitter @SourCL_Stefan"));
```


<hr>

### Get funds on testnet
Visit: https://faucet.testnet.chrysalis2.com/


<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


<hr>

Back to [Overview](000_index.md)