![IOTA.php](./images/IOTA_PHP_Banner_Interact_Help.png)

<p style="text-align:center;">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>
  <a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>
  <a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA"></a>
  <a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square&logo=php" alt=">PHP 8"></a>
  <img src="https://github.com/iota-community/iota.php/actions/workflows/phpunit.yml/badge.svg" alt="WorkflowUnitTest">
  <a href="https://packagist.org/packages/iota-community/iota.php/" style="text-decoration:none;"><img src="https://poser.pugx.org/iota-community/iota.php/v/stable.png" alt=">packagist_stable"></a>
</p>

# Examples Identity (verify)

### Include

```php
<?php
  // include iota lib
  require_once("autoload.php");
```

### verify DID

```php
  //
  $jsonString = '{
  "id": "did:iota:test:4ga5nnMBLcUbbpUpBQRfZY3PCNiJp6Lfu6A1wJ4oXA4y",
  "authentication": [
    {
      "id": "did:iota:test:4ga5nnMBLcUbbpUpBQRfZY3PCNiJp6Lfu6A1wJ4oXA4y#key",
      "controller": "did:iota:test:4ga5nnMBLcUbbpUpBQRfZY3PCNiJp6Lfu6A1wJ4oXA4y",
      "type": "Ed25519VerificationKey2018",
      "publicKeyBase58": "5woWnfs5C6qVyc5V72sZ2rHWZpZogruhcPittiNRohZg"
    }
  ],
  "created": "2021-07-26T20:26:20Z",
  "updated": "2021-07-26T20:26:20Z",
  "proof": {
    "type": "JcsEd25519Signature2020",
    "verificationMethod": "#key",
    "signatureValue": "54WtuHRCJq4YFUDq1HaFNMStvsLYvLBHhb9TebGHTZfKoo1FMNrc2EsEHHMfKW6hg2cbn4Gzc762qJfCi6AntEY9"
  }
}';
  // verify
  $result = \IOTA\Identity::verify($jsonString);
  // output
  var_dump($result);
```


### verify DID TangleMessage

```php
  // verify TangleMessage
  $result = \IOTA\Identity::verifyTangleMessage("30e10e1995b66d1be864a16b692b08b63d4e02eaa737f88d134d8678fd05b081");
  // output
  var_dump($result);
```

---

## Additional Examples

Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)