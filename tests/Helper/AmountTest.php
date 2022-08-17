<?php declare(strict_types = 1);
  require_once "./autoload.php";

  use PHPUnit\Framework\TestCase;
  use IOTA\Helper\Amount;

  /**
   * Class AmountTest
   *
   * @author       StefanBraun @tanglePHP
   * @copyright    Copyright (c) 2021, StefanBraun
   */
  final class AmountTest extends TestCase {
    public function testAmount(): void {
      $ret                   = [];
      $ret[1]                = new Amount("1");
      $ret[10]              = new Amount("0.01ki");
      $ret[100]              = new Amount("0.1ki");
      $ret[1000]             = new Amount("1ki");
      $ret[10000]            = new Amount("10ki");
      $ret[100000]           = new Amount("100kI");
      $ret[1000000]          = new Amount("1mi");
      $ret[10000000]         = new Amount("10Mi");
      $ret[100000000]        = new Amount("100MI");
      $ret[1000000000]       = new Amount("1gi");
      $ret[10000000000]      = new Amount("0.01ti");
      $ret[100000000000]     = new Amount("0.1ti");
      $ret[1000000000000]    = new Amount("1ti");
      $ret[10000000000000]   = new Amount("10ti");
      $ret[100000000000000]  = new Amount("0.1pi");
      $ret[1000000000000000] = new Amount("1pi");
      $ret[2779530283277761] = new Amount("2779530283277761i");
      $ret[2779000000]       = new Amount("2779mi");
      //
      foreach($ret as $k => $amount) {
        $this->assertEquals($amount->getAmount(), $k);
      }
    }
  }
