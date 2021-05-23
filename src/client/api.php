<?php namespace iota\client;
/**
 * Class api
 *
 * @package iota\client
 */
class api extends \iota\client {
  public \iota\api\node $node;
  public \iota\api\tangle $tangle;
  public \iota\api\messages $messages;
  public \iota\api\milestones $milestones;
  public \iota\api\peers $peers;
  public \iota\api\utxo $utxo;

  public function __construct(string $API_ENDPOINT, protected array $_options = []) {
    parent::__construct($API_ENDPOINT, $this->_options);
    //
    $this->node       = new \iota\api\node($this);
    $this->tangle     = new \iota\api\tangle($this);
    $this->messages   = new \iota\api\messages($this);
    $this->milestones = new \iota\api\milestones($this);
    $this->peers      = new \iota\api\peers($this);
    $this->utxo       = new \iota\api\utxo($this);
  }
}