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
    return new \iota\schemas\response\Peers($this->_client->fetchArray("get", "peers"));
  }

  /**
   * Get information about a given peer.
   *
   * @param string|null $peerId
   *
   * @return \iota\schemas\response\Peer
   */
  public function get(string $peerId): \iota\schemas\response\Peer {
    return new \iota\schemas\response\Peer($this->_client->fetchArray("get", "peers/{$peerId}"));
  }

  /**
   * Add a given peer to the node.
   *
   * @param string $multiAddress
   * @param string $alias
   *
   * @return \iota\schemas\response\AddPeer
   */
  public function add(string $multiAddress, string $alias = ""): \iota\schemas\response\AddPeer {
    $_request               = new \iota\schemas\request\AddPeer();
    $_request->multiAddress = $multiAddress;
    $_request->alias        = $alias;

    return new \iota\schemas\response\AddPeer($this->_client->fetchArray("post", "peers", $_request->__toJSON()));
  }

  /**
   * Remove/disconnect a given peer.
   *
   * @param string $peerId
   *
   * @return string
   */
  public function delete(string $peerId): string {
    return $this->_client->fetch("delete", "peers/{$peerId}");
  }
}