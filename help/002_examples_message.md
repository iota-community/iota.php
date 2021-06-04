<h2 align="center">iota.php</h2>

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?logo=discord" alt="Discord"></a>
    <img src="https://img.shields.io/badge/license-Apache--2.0-green" alt="Apache-2.0 license">
</p>

# Examples (Message)

### Include and create a client

```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
```

### Send message

```php
  $result = $client->sendMessage('#iota.php', 'message test! follow me on Twitter @SourCL_Stefan');
```

### Get message

```php
  echo $client->getMessage($result->messageId);
```

### Get messagePayload

```php
  echo $client->getMessagePayload($result->messageId);
```


### Fetch message

```php
  $found = $client->messagesFind(\iota\converter::bin2hex('#iota.php'));
  if(\count($found->messageIds) > 0) {
    echo "Messages Found: " . \count($found->messageIds) . LF;
    $lastData = $client->getMessagePayload(\end($found->messageIds));
    echo $lastData->data. LF;
  }
  else {
    echo "No Results!" . LF;
  }
```

<hr>

## Additional Examples

Please find other examples in the [examples](../examples) folder.


<hr>

Back to [Overview](000_index.md)