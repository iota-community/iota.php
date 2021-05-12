<?php namespace iota;
/**
 * Class client
 *
 * @package iota
 */
abstract class client {
  /**
   * @var mixed|string
   */
  protected $_basePath;
  /**
   * @var int|mixed
   */
  protected $_timeOut = 0;
  /**
   * @var mixed|null
   */
  protected $_user;
  /**
   * @var mixed|null
   */
  protected $_pass;
  /**
   * @var string[]
   */
  protected $_headers = [
    'accept: application/json',
    'content-type: application/json',
  ];

  /**
   * client constructor.
   *
   * @param string $API_ENDPOINT
   * @param array  $_options
   */
  public function __construct(public string $API_ENDPOINT, protected $_options = []) {
    $this->API_ENDPOINT .= \substr($this->API_ENDPOINT, -1) == '/' ? '' : '/';
    $this->_basePath    = $_options['basePath'] ?? 'api/v1/';
    $this->_user        = $_options['user'] ?? null;
    $this->_pass        = $_options['pass'] ?? null;
  }

  /**
   * @var helper\curl
   */
  private \iota\helper\curl $_handle;

  /**
   * @param string           $method
   * @param string           $route
   * @param helper\json|null $_requestData
   *
   * @return array
   * @throws \Exception
   */
  public function fetch(string $method, string $route, \iota\helper\json|null $_requestData = null) {
    $_url          = $this->API_ENDPOINT . ($route[0] != "/" ? $this->_basePath . $route : \substr($route, 1));
    $this->_handle = new \iota\helper\curl($_url);
    //
    $this->_handle->setOption(CURLOPT_CONNECTTIMEOUT, $this->_timeOut);
    if($method == "delete") {
      $this->_handle->setOption(CURLOPT_CUSTOMREQUEST, $method);
    }
    // set post data
    if($_requestData) {
      $this->_handle->setOption(CURLOPT_POSTFIELDS, $_requestData);
    }
    if($this->_user && $this->_pass) {
      if(!\strstr($_url, "https://")) {
        throw new \Exception("Basic authentication requires the endpoint to be https");
      }
      $this->_handle->setOption(CURLOPT_USERPWD, $this->_user . ":" . $this->_pass);
      //$this->_headers[] = "Authorization: Basic " . \iota\converter::strtobase64($this->_user . ":" . $this->_pass);
    }
    $this->_handle->setOption(CURLOPT_HTTPHEADER, $this->_headers);

    return $this->_handle->exec();
  }

  /**
   * @param string           $method
   * @param string           $route
   * @param helper\json|null $_requestData
   *
   * @return helper\json
   * @throws \Exception
   */
  public function fetchJSON(string $method, string $route, \iota\helper\json|null $_requestData = null) {
    $this->fetch($method, $route, $_requestData);
    $_content = $this->_handle->getContent();
    if(!($_json = new \iota\helper\json($_content))->isJSON) {
      die($_json);
    }
    if(isset($_json['error'])) {
      die(new \iota\schemas\response\Error($_json['error']));
    }

    return $_json;
  }

  /**
   * @param string           $method
   * @param string           $route
   * @param helper\json|null $_requestData
   *
   * @return array
   * @throws \Exception
   */
  public function fetchArray(string $method, string $route, \iota\helper\json|null $_requestData = null) {
    return $this->fetchJSON($method, $route, $_requestData)
                ->__toArray();
  }

  /**
   * @param string           $method
   * @param string           $route
   * @param helper\json|null $_requestData
   *
   * @return mixed
   * @throws \Exception
   */
  public function fetchStatus(string $method, string $route, \iota\helper\json|null $_requestData = null) {
    $this->fetch($method, $route, $_requestData);

    return $this->_handle->getStatus();
  }

  /**
   * @return bool
   */
  abstract public function health(): bool;

  /**
   * @return schemas\response\Info
   */
  abstract public function info(): \iota\schemas\response\Info;

  /**
   * @return schemas\response\Tips
   */
  abstract public function tips(): \iota\schemas\response\Tips;

  /**
   * @param string $messageId
   *
   * @return schemas\response\Message
   */
  abstract public function message(string $messageId): \iota\schemas\response\Message;

  /**
   * @param schemas\request\SubmitMessage $message
   *
   * @return schemas\response\SubmitMessage
   */
  abstract public function messageSubmit(\iota\schemas\request\SubmitMessage $message): \iota\schemas\response\SubmitMessage;

  /**
   * @param string $index
   *
   * @return schemas\response\MessagesFind
   */
  abstract public function messagesFind(string $index): \iota\schemas\response\MessagesFind;

  /**
   * @param string $messageId
   *
   * @return mixed
   */
  abstract public function messageRaw(string $messageId);

  /**
   * @param string $messageId
   *
   * @return schemas\response\MessageChildren
   */
  abstract public function messageChildren(string $messageId): \iota\schemas\response\MessageChildren;

  /**
   * @param string $index
   *
   * @return schemas\response\Milestone
   */
  abstract public function milestone(string $index): \iota\schemas\response\Milestone;

  /**
   * @param string $index
   *
   * @return schemas\response\Milestone
   */
  abstract public function milestoneUtxoChanges(string $index): \iota\schemas\response\Milestone;

  /**
   * @return schemas\response\Peers
   */
  abstract public function peers(): \iota\schemas\response\Peers;

  /**
   * Add a given peer to the node.
   *
   * @param string $multiAddress
   * @param string $alias
   *
   * @return \iota\schemas\response\AddPeer
   */
  abstract public function peerAdd(string $multiAddress, string $alias = null): \iota\schemas\response\AddPeer;

  /**
   * Remove/disconnect a given peer.
   *
   * @param string $peerId
   *
   * @return string
   */
  abstract public function peerDelete(string $peerId): void;

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return \iota\schemas\response\Output
   */
  abstract public function output(string $outputId): \iota\schemas\response\Output;

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return \iota\schemas\response\Output
   */
  abstract public function address(string $addressBech32): \iota\schemas\response\BalanceAddress;

  /**
   * Get all outputs that use a given bech32-encoded address
   *
   * @param string $addressBech32 bech32-encoded address that is referenced by the outputs.
   * @param int    $type          Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   * @param bool   $includeSpend  Set to true to also include the known spent outputs for the given address.
   *
   * @return \iota\schemas\response\OutputAddress
   */
  abstract public function addressesOutput(string $addressBech32, int $type = 0, bool $includeSpend = false): \iota\schemas\response\OutputAddress;

  /**
   * Get the balance of a hex-encoded Ed25519 address
   *
   * @param string $addressEd25519
   *
   * @return \iota\schemas\response\BalanceAddress
   * @throws \Exception
   */
  abstract public function addressEd25519(string $addressEd25519): \iota\schemas\response\BalanceAddress;

  /**
   * Get all outputs that use a given hex-encoded Ed25519 address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressEd25519 hex-encoded Ed25519 address that is referenced by the outputs.
   * @param int    $type           Allows to filter the results by output type. Set to value 0 to filter outputs of type SigLockedSingleOutput. Set to value 1 to filter outputs of type SigLockedDustAllowanceOutput
   * @param bool   $includeSpend   Set to true to also include the known spent outputs for the given address.
   *
   * @return \iota\schemas\response\OutputAddress
   */
  abstract public function addressesed25519Output(string $addressEd25519, int $type = 0, bool $includeSpend = false): \iota\schemas\response\OutputAddress;

  /**
   * Get all the stored receipts or those for a given migrated at index.
   *
   * @param int|null $migratedAt
   *
   * @return \iota\schemas\response\Receipts
   * @throws \Exception
   */
  abstract public function receipts(int $migratedAt = null): \iota\schemas\response\Receipts;

  /**
   * Returns information about the treasury
   *
   * @return \iota\schemas\response\Receipts
   * @throws \Exception
   */
  abstract public function treasury(): \iota\schemas\response\Treasury;
}