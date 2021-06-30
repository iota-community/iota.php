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
   * @param int|string $amount
   *
   * @throws ExceptionHelper
   */
  public function __construct(int|string $amount) {
    if(is_numeric($amount) || is_numeric(substr($amount, -2, 1)) && strtolower(substr($amount, -1)) == 'i') {
      $this->amount = (int)$amount;
      $this->unit   = 'i';
    }
    else {
      $unit = strtolower(substr($amount, -2));
      $int  = strtolower(substr($amount, 0, -2));
      if(array_key_exists($unit, $this->units)) {
        $this->unit = $unit;
        $math       = $int * $this->units[$unit];
        if(is_float($math)) {
          throw new ExceptionHelper("calc '$math' mount is not a valid value (amountInput='$amount')");
        }
        $this->amount = $math;
      }
      else {
        throw new ExceptionHelper("Unknown amount '$amount'");
      }
    }
    if($this->amount > $this->max) {
      throw new ExceptionHelper("Ammount '$this->amount't is higher than max possible '$this->max'");
    }
  }

  /**
   * @return int
   */
  public function getAmount(): int {
    return (int)$this->amount;
  }
}