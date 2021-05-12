<?php namespace iota\api;
/**
 * Everything about the peers of the node.
 *
 * @package      iota\api
 */
class peers extends \iota\api {
  /**
   * Get information about the peers of the node.
   *
   * @return \iota\schemas\response\Peers
   */
  public function list(): \iota\schemas\response\Peers {
    return $this->fetch([
      'route'  => "peers",
      'return' => \iota\schemas\response\Peers::class,
    ]);
  }

  /**
   * Get information about a given peer.
   *
   * @param string|null $peerId
   *
   * @return \iota\schemas\response\Peer
   */
  public function get(string $peerId): \iota\schemas\response\Peer {
    return $this->fetch([
      'route'  => "peers/{$peerId}",
      'return' => \iota\schemas\response\Peer::class,
    ]);
  }

  /**
   * Add a given peer to the node.
   *
   * @param string $multiAddress
   * @param string $alias
   *
   * @return \iota\schemas\response\AddPeer
   */
  public function add(string $multiAddress, string $alias = null): \iota\schemas\response\AddPeer {
    $_request               = new \iota\schemas\request\AddPeer();
    $_request->multiAddress = $multiAddress;
    $_request->alias        = $alias ?? '';

    return $this->fetch([
      'method'      => 'post',
      'route'       => "peers",
      'requestData' => $_request->__toJSON(),
      'return'      => \iota\schemas\response\AddPeer::class,
    ]);
  }

  /**
   * Remove/disconnect a given peer.
   *
   * @param string $peerId
   *
   * @return string
   */
  public function delete(string $peerId): void {
    $this->fetch([
      'route' => "peers/{$peerId}",
    ]);
  }
}