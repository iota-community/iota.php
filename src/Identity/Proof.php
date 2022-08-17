<?php namespace IOTA\Identity;

use IOTA\Models\AbstractMap;

/**
 * Class Proof
 *
 * @package      IOTA\Identity
 * @author       StefanBraun @tanglePHP
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Proof extends AbstractMap {
  /**
   * @var string
   */
  public string $type = 'JcsEd25519Signature2020';
  /**
   * @var string
   */
  public string $verificationMethod = '#key';
  /**
   * @var string
   */
  public string $signatureValue;
}