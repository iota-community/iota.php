<h2 align="center">iota.php</h2>

<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?logo=discord" alt="Discord"></a>
    <img src="https://img.shields.io/badge/license-Apache--2.0-green" alt="Apache-2.0 license">
</p>

# About

PHP library to use IOTA REST API to help node management and tangle queries.

> Please be aware that this library is in an early development state and the API 
of the library as well as the IOTA protocol is subject to change, it is NOT ready to use in 
production.

# Requirements
 + PHP8+
 + PHP Extensions: 
   + [ext-curl](http://php.net/manual/en/book.curl.php)
   + [ext-sodium](http://php.net/manual/en/book.sodium.php) (api client don't need this)


# Example
```php
<?php
  // include iota lib
  require_once("../iota.php");
  // create client
  $client = new iota('https://api.lb-0.testnet.chrysalis2.com');
  // print result of node information
  echo $client->info();
```

## Additional Examples

Please find other examples in the [./examples](examples) folder.


<hr>

## Joining the discussion

If you want to get involved in the community, need help with getting set up, have any issues or just want to discuss IOTA, feel free to join our [Discord](https://discord.iota.org/).