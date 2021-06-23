![IOTA.php](./help/images/header.jpg)


<p align="center">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>

<img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license">
<img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA">
<img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square" alt=">PHP 8">
</p>

# About

PHP library to use IOTA REST API to help node management and tangle queries.

> Please be aware that this library is in an early development state and the API of the library as well as the IOTA protocol is subject to change, it is NOT ready to use in production.

This library allows you to do the following:

- [x] Create messages with indexation and transaction payloads
- [x] Get messages and outputs
- [x] Generate addresses
- [x] Interact with an IOTA node

# Requirements

+ PHP 8+
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

# Using iota.php library

**Using the library is _easy_, more information can be found [here](help/000_index.md).**

Additional Examples: Please find other examples in the [./examples](examples) folder.

<hr>


### Joining the discussion

<a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
<a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>

If you want to get involved in the community, need help with getting set up, have any issues or just want to discuss IOTA, feel free to join
our [Discord](https://discord.iota.org/).

> Follow me on Twitter [@IOTAphp](https://twitter.com/IOTAphp)

<hr>

### Donation

It took me a lot of time to develop **iota.php** and need to pay for the server every month. If you want to support me or if my work helps you, kindly consider a small donation.

[<img src="https://img.shields.io/badge/iota1qppu7wdws394euyvflvevsnpdawvsl820c3c3jy92wky6wfj656wqqxtf9m-lightgrey?style=social&logo=iota" alt="IOTA">](./help/100_Donation.md)


<hr>

# License

The Apache 2.0 license can be found [here](LICENCE.md).