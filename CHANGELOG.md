![IOTA.php](./help/images/IOTA_PHP_Banner_Interact.png)

<p style="text-align:center;">
  <a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
  <a href="https://twitter.com/IOTAphp/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-9cf.svg?style=social&logo=twitter" alt="Twitter"></a>
  <br>
  <a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>
  <a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-lightgrey?style=flat&logo=iota" alt="IOTA"></a>
  <a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.x-blue?style=flat-square&logo=php" alt=">PHP 8"></a>
  <img src="https://github.com/iota-community/iota.php/actions/workflows/phpunit.yml/badge.svg" alt="WorkflowUnitTest">
</p>

# Changelog

## 0.2.3 - 2021-07-12

### Added

- get Historic Balances
  - Add new Wallet/Address method
  - Add Example Wallet/05_WalletGetHistoricBalances
  - Add Help Wallet/020_examples_wallet_getHistoricBalance

### Changed

- checkTransactionTest 
  - ResponseError

## 0.2.2 - 2021-07-01

### Added

- Helper\Amount

### Changed

- Helper\ApiCaller default timeout = 30
- FaucetClient timeout handle

  
## 0.2.1 - 2021-06-30

### Added

- Wallet Help
  - useWallet
  - searchWalletAddress
  - sendTokens
  
### Changed

- searchAddresses
  - zeroBalance default to false

## 0.2.0 - 2021-06-30

### Added

- Wallet class
  - address management
  - get balance over Wallet\Address 
  - send tokens over Wallet\Address 
  - address Searcher
  
- Wallet examples

## 0.1.0 - 2021-06-28

### Added

- Builder
- iota.phar
- phpunit tests
- autoloader.php
- composer.json

### Changed

- New [Iota.php](https://github.com/iota-community/iota.php) lib structure
- New [example](./examples) structure
- [Iota.php Help](./help/000_index.md)

### Removed

- Old lib structure
- Old example structure
- client/Api