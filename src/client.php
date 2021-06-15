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
  public function __construct(public string $API_ENDPOINT, protected array $_options = []) {
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
   * @return string
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
      $this->_handle->setOption(CURLOPT_POSTFIELDS, (string)$_requestData);
    }
    if($this->_user && $this->_pass) {
      if(!\strstr($_url, "https://")) {
        throw new exception\client("Basic authentication requires the endpoint to be https");
      }
      $this->_handle->setOption(CURLOPT_HTTPAUTH, CURLAUTH_ANY);
      $this->_handle->setOption(CURLOPT_USERPWD, $this->_user . ":" . $this->_pass);
      //$this->_headers[] = "Authorization: Basic " . \iota\converter::base64_encode($this->_user . ":" . $this->_pass);
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
  public function fetchJSON(string $method, string $route, \iota\helper\json|null $_requestData = null): \iota\helper\json {
    $this->fetch($method, $route, $_requestData);
    $_content = $this->_handle->getContent();
    if(!($_json = new \iota\helper\json($_content))->isJSON) {
      die("Bad content: " . $_content);
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
  public function fetchArray(string $method, string $route, \iota\helper\json|null $_requestData = null): array {
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
  public function fetchStatus(string $method, string $route, \iota\helper\json|null $_requestData = null):mixed {
    $this->fetch($method, $route, $_requestData);

    return $this->_handle->getStatus();
  }
}