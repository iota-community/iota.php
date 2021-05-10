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
    $this->_handle->setOption(CURLOPT_HTTPHEADER, [
      'accept: application/json',
      'content-type: application/json',
    ]);
    if($method == "delete") {
      $this->_handle->setOption(CURLOPT_CUSTOMREQUEST, $method);
    }
    // set post data
    if($_requestData) {
      $this->_handle->setOption(CURLOPT_POSTFIELDS, $_requestData);
    }

    return $this->_handle->exec();
  }

  /**
   * @param string           $method
   * @param string           $route
   * @param helper\json|null $_requestData
   *
   * @return mixed
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
   * @return helper\json
   * @throws \Exception
   */
  public function fetchJSON(string $method, string $route, \iota\helper\json|null $_requestData = null) {
    $this->fetch($method, $route, $_requestData);
    $_content = $this->_handle->getContent();
    if(!($_json = new \iota\helper\json($_content))->isJSON || isset($_json->decode(true)['error'])) {

      die($_content);
    }

    return new \iota\helper\json($this->_handle->getContent());
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
   * @return schemas\Message
   */
  abstract public function message(string $messageId): \iota\schemas\Message;

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
}