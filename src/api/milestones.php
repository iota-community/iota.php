<?php namespace iota\api;
/**
 * Everything about milestones.
 *
 * @package      iota\api
 */
class milestones extends \iota\api {
  /**
   * Look up a milestone by a given milestone index.
   *
   * @param string $index
   *
   * @return \iota\schemas\response\Milestone
   */
  public function get(string $index): \iota\schemas\response\Milestone {
    return $this->fetch([
      'route'  => "milestones/{$index}",
      'return' => \iota\schemas\response\Milestone::class,
    ]);
  }

  /**
   * Get all UTXO changes of a given milestone
   *
   * @param string $index
   *
   * @return \iota\schemas\response\UTXOChanges
   */
  public function utxoChanges(string $index): \iota\schemas\response\UTXOChanges {
    return $this->fetch([
      'route'  => "milestones/{$index}/utxo-changes",
      'return' => \iota\schemas\response\Milestone::class,
    ]);
  }
}