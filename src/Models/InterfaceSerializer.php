<?php namespace IOTA\Models;
/**
 * Interface InterfaceSerializer
 *
 * @package      IOTA\Models
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
interface InterfaceSerializer {
  /**
   * @return array
   */
  public function serialize(): array;

  /**
   * @return string
   */
  public function serializeToHash(): string;

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeInt(string $value): string;

  /**
   * @param string $value
   *
   * @return mixed
   */
  static public function serializeUInt16(string $value): string;

  /**
   * @param string $value
   *
   * @return mixed
   */
  static public function serializeBigInt(string $value): string;

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeFixedHex(string $value): string;
}