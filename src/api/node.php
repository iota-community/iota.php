<?php namespace iota\api;
/**
 * Everything about the node itself.
 *
 * @package      iota\api
 */
class node extends \iota\api {
  /**
   * Returns the health of the node.
   * A node considers itself healthy if its solid milestone is at most two delta away from the latest known milestone, has at least one ongoing gossip stream and the latest known milestone is newer than 5 minutes. This information might be useful for load-balancing or uptime monitoring.
   *
   * @return bool
   * @throws \Exception
   */
  public function health(): bool {
    $_status = $this->fetch([
      'fetch' => 'Status',
      'route' => "/health",
    ]);
    switch($_status['http_code']) {
      case '200':
        return true;
      case '503':
        return false;
      default:
        throw new \Exception("/health Unexpected response code '{$_status['http_code']}'");
    }
  }

  /**
   * Returns general information about the node.
   *
   * @return \iota\schemas\response\Info
   */
  public function info(): \iota\schemas\response\info {
    return $this->fetch([
      'route'  => "info",
      'return' => \iota\schemas\response\Info::class,
    ]);
  }
}