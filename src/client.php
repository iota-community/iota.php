<?php namespace iota;
/**
 * Class client
 *
 * @package iota
 */
class client {
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
}