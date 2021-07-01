<?php namespace IOTA\Helper;

use IOTA\Exception\Helper as ExceptionHelper;

/**
 * Class Amount
 *
 * @package      IOTA\Helper
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Amount {
  /**
   * @var int
   */
  protected int $amount;
  /**
   * @var string
   */
  protected string $unit;
  /**
   * @var array|int[]
   */
  protected array $units = [
    'i'  => 1,
    'ki' => 1000,
    'mi' => 1000000,
    'gi' => 1000000000,
    'ti' => 1000000000000,
    'pi' => 1000000000000000,
  ];
  /**
   * @var int
   */
  protected int $max = 2779530283277761;

  /**
   * Amount constructor.
   *
   * @param int|string|Amount $amount
   *
   * @throws ExceptionHelper
   */
  public function __construct(int|string|Amount $amount) {
    if($amount instanceof Amount) {
      $amount = $amount->getAmount();
    }
    if(is_numeric($amount) || is_numeric(substr($amount, -2, 1)) && strtolower(substr($amount, -1)) == 'i') {
      $this->amount = (int)$amount;
      $this->unit   = 'i';
    }
    else {
      $unit = strtolower(substr($amount, -2));
      $int  = strtolower(substr($amount, 0, -2));
      if(array_key_exists($unit, $this->units)) {
        $this->unit   = $unit;
        $math         = $int * $this->units[$unit];
        $this->amount = $math;
      }
      else {
        throw new ExceptionHelper("Unknown amount '$amount'");
      }
    }
    if($this->amount > $this->max) {
      throw new ExceptionHelper("Amount '$this->amount' is higher than max possible '$this->max'");
    }
  }

  /**
   * @return int
   */
  public function getAmount(): int {
    return (int)$this->amount;
  }

  /**
   * @return string
   */
  public function toPi(): string {
    return $this->calcTo('pi');
  }

  /**
   * @return string
   */
  public function toTi(): string {
    return $this->calcTo('ti');
  }

  /**
   * @return string
   */
  public function toGi(): string {
    return $this->calcTo('gi');
  }

  /**
   * @return string
   */
  public function toMi(): string {
    return $this->calcTo('mi');
  }

  /**
   * @return string
   */
  public function toKi(): string {
    return $this->calcTo('ki');
  }

  /**
   * @return string
   */
  public function toi(): string {
    return $this->calcTo('i');
  }

  /**
   * @param $to
   *
   * @return string
   */
  private function calcTo($to): string {
    $ret = rtrim(bcdiv($this->amount, $this->units[$to], 15), 0);

    return (substr($ret, -1) == '.' ? substr($ret, 0, -1) : $ret) . $to;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return (string)$this->getAmount();
  }
}