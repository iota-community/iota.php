<?php namespace IOTA\Action;

use IOTA\Api\v1\ResponseMessageMetadata;
use IOTA\Api\v1\ResponseSubmitMessage;
use IOTA\Models\AbstractAction;
use IOTA\Api\v1\ResponseError;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;

/**
 * Class checkTransaction
 *
 * @package      IOTA\Action
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class checkTransaction extends AbstractAction {
  public array $conflictReason = [
    1 => "referenced UTXO was already spent.",
    2 => "referenced UTXO was already spent while confirming this milestone.",
    3 => "referenced UTXO cannot be found.",
    4 => "sum of the inputs and output values does not match.",
    5 => "unlock block signature is invalid.",
    6 => "input or output type used is unsupported.",
    7 => "used address type is unsupported.",
    8 => "dust allowance for the address is invalid.",
    9 => "semantic validation failed.",
  ];
  /**
   * @var string
   */
  protected string $messageId;

  /**
   * @param string $messageId
   *
   * @return $this
   */
  public function messageId(string $messageId): self {
    $this->messageId = $messageId;

    return $this;
  }

  /**
   * @return string
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function run(): string {
    $this->result = $this->client->messageMetadata($this->messageId);
    if($this->result instanceof ResponseMessageMetadata) {
      if(!isset($this->result->ledgerInclusionState)) {
        sleep(1);

        return $this->run();
      }
      if($this->result->ledgerInclusionState == "included") {
        $returnValue = "included";
      }
      else {
        $returnValue = $this->conflictReason[$this->result->conflictReason];
      }
    } else {
      $returnValue = $this->result->message;
    }
    $this->callCallback($returnValue);

    return $returnValue;
  }

  /**
   * @return ResponseSubmitMessage|ResponseError
   */
  public function getResult(): ResponseMessageMetadata|ResponseError {
    return parent::getResult();
  }
}