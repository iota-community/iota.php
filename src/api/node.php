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
   * @return string
   */
  public function health(): bool {
    $_status = $this->_client->fetchStatus("get", "/health");
    if($_status['http_code'] == '200') {
      return true;
    }
    if($_status['http_code'] == '503') {
      return false;
    }
    throw new \Exception("/health Unexpected response code '{$_status['http_code']}'");
  }

  /**
   * Returns general information about the node.
   *
   * @return \iota\schemas\response\Info
   */
  public function info(): \iota\schemas\response\info {
    return new \iota\schemas\response\Info($this->_client->fetchArray("get", "info"));
  }
}