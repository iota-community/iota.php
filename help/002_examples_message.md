![tanglePHP](./images/IOTA_PHP_Banner_Interact_Help.png)

<p style="text-align:center;">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/tanglePHP/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>
  <a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>
  <a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA"></a>
  <a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square&logo=php" alt=">PHP 8"></a>
  <img src="https://github.com/iota-community/iota.php/actions/workflows/phpunit.yml/badge.svg" alt="WorkflowUnitTest">
  <a href="https://packagist.org/packages/iota-community/iota.php/" style="text-decoration:none;"><img src="https://poser.pugx.org/iota-community/iota.php/v/stable.png" alt=">packagist_stable"></a>
</p>

# Basics examples (Message)

### Include and create a client

```php
<?php
  // include iota lib
  require_once("autoload.php");
  // create client
  $client = new IOTA\Client\SingleNodeClient();
```

### Send message

```php
  echo $client->messageSubmit(new IOTA\Api\v1\PayloadIndexation('#tanglePHP', 'message test! follow me on Twitter @tanglePHP'));
```

### Get message

```php
  echo $client->message($result->messageId);
```

### Fetch message

```php
  $found = $client->messagesFind('#tanglePHP');
  if(count($found->messageIds) > 0) {
    echo "Messages Found: " . count($found->messageIds) . PHP_EOL;
    $lastData = $client->message(end($found->messageIds));
    echo $lastData->payload->data;
  }
  else {
    echo "No Results!" . LF;
  }
```

<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


___

<- Back to [Overview](000_index.md)