<h2 align="center">iota.php</h2>

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/SourCL_Stefan/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
</p>

# Advanced Examples (Mnemonic)

### Include

```php
<?php
  // include iota lib
  require_once("../iota.php");
```

### Create mnemonic

```php
  $words     = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
  $_mnemonic = (new \iota\crypto\Bip39())->reverseMnemonic($words);
```

### Creating random mnemonic

```php
  $mnemonic = (new \iota\crypto\Bip39())->randomMnemonic();
  #echo \implode(" ", $mnemonic->words)
```

### Get seed from mnemonic

```php
  echo $mnemonic->__toSeed();
```

### Create ed25519Seed

```php
  $ed25519Seed = new \iota\type\seed\ed25519(((new \iota\crypto\Bip39())->reverseMnemonic($words))->__toSeed());
```

<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


<hr>

Back to [Overview](000_index.md)