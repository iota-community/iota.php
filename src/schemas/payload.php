<?php namespace iota\schemas;
/**
 * Class payload
 *
 * @package iota\schemas
 */
abstract class payload extends \iota\schemas {
  /**
   *
   */
  const iota_payload_type_0 = \iota\schemas\payload\Transaction::class;
  /**
   *
   */
  const iota_payload_type_1 = \iota\schemas\payload\Milestone::class;
  /**
   *
   */
  const iota_payload_type_2 = \iota\schemas\payload\Indexation::class;
  /**
   *
   */
  const iota_payload_type_4 = \iota\schemas\payload\TreasuryTransaction::class;
  /**
   * todo@all: Dont know if this type is realy type = 3
   */
  const iota_payload_type_3 = \iota\schemas\payload\Receipt::class;
  /**
   * @var int
   */
  public int $type;
}