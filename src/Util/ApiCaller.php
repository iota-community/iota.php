<?php namespace IOTA\Util;

use IOTA\Api\v1\ResponseError;
use IOTA\Exception\Helper as ExceptionHelper;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Helper\Converter;
use IOTA\Helper\Curl;
use IOTA\Helper\JSON;

/**
 * Class ApiCaller
 *
 * @package      IOTA\Api
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class ApiCaller {
  /**
   * @var Curl
   */
  protected Curl $handle;
  /**
   * @var string
   */
  public string $basePath = '';
  /**
   * @var string[]
   */
  protected array $headers = [];
  /**
   * @var string|null
   */
  protected ?string $route;
  /**
   * @var array
   */
  protected array $query = [];
  /**
   * @var string|null
   */
  protected ?string $callback;
  /**
   * @var array
   */
  protected array $settings = [
    'jsonException' => true,
    'jsonData'      => 'data',
    'jsonError'     => 'error',
  ];

  /**
   * ApiCaller constructor.
   *
   * @param string      $url
   * @param string      $method
   * @param mixed|null  $requestData
   * @param string|null $userPass
   *
   * @throws ExceptionApi
   */
  public function __construct(protected string $url, protected string $method = 'get', protected mixed $requestData = null, protected ?string $userPass = null) {
    $this->url($url);
    $this->method($method);
    $this->requestData($requestData);
    $this->userPass($userPass);
  }

  /**
   * @param string $url
   *
   * @return $this
   */
  public function url(string $url): self {
    $this->url = $url . (substr($this->url, -1) == '/' ? '' : '/');

    return $this;
  }

  /**
   * @param string $route
   *
   * @return $this
   */
  public function route(string $route): self {
    $this->route = $route;

    return $this;
  }

  /**
   * @param array $query
   *
   * @return $this
   */
  public function query(array $query): self {
    $this->query = $query;

    return $this;
  }

  /**
   * @param string $method
   *
   * @return $this
   * @throws ExceptionApi
   */
  public function method(string $method): self {
    $method = strtoupper($method);
    if(!in_array($method, [
      'GET',
      'POST',
      'DELETE',
      'PUT',
    ])) {
      throw new ExceptionApi();
    }
    $this->method = $method;

    return $this;
  }

  /**
   * @param mixed $requestData
   *
   * @return $this
   */
  public function requestData(mixed $requestData): self {
    $this->requestData = $requestData;

    return $this;
  }

  /**
   * @param string|null $userPass
   *
   * @return $this
   * @throws ExceptionApi
   */
  public function userPass(?string $userPass): self {
    if(is_string($userPass) && !strpos($userPass, ":")) {
      throw new ExceptionApi("wrong userPass format 'user:pass'");
    }
    $this->userPass = $userPass;

    return $this;
  }

  /**
   * @param string $basePath
   *
   * @return $this
   */
  public function basePath(string $basePath): self {
    $this->basePath = empty($basePath) ? '' : (substr($basePath, -1) == '/' ? $basePath : $basePath . '/');

    return $this;
  }

  /**
   * @param string $callback
   *
   * @return $this
   */
  public function callback(string $callback): self {
    $this->callback = $callback;

    return $this;
  }

  /**
   * @param string $key
   * @param        $value
   *
   * @return $this
   */
  public function settings(string $key, $value): self {
    $this->settings[$key] = $value;

    return $this;
  }

  /**
   * @param int $timeout
   *
   * @return string
   * @throws ExceptionApi
   */
  public function fetch(int $timeout = 30): string {
    $_url   = $this->url . ($this->route[0] != "/" ? $this->basePath . $this->route : substr($this->route, 1));
    $_query = (count($this->query) > 0 ? '?' . http_build_query($this->query) : '');
    //
    try {
      $this->handle = new Curl($_url . $_query);
    }
    catch(ExceptionHelper $exception) {
      throw new ExceptionApi("Can not create IOTA/Helper/Curl '" . $exception->getMessage() . "'");
    }
    //
    $this->handle->setOption(CURLOPT_CONNECTTIMEOUT, $timeout);
    $this->handle->setOption(CURLOPT_TIMEOUT, $timeout);
    if($this->method == "DELETE") {
      $this->handle->setOption(CURLOPT_CUSTOMREQUEST, $this->method);
    }
    if($this->method == "PUT") {
      $this->handle->setOption(CURLOPT_PUT, 1);
    }
    // set post data
    if($this->requestData) {
      $this->handle->setOption(CURLOPT_POST, 1);
      $this->handle->setOption(CURLOPT_POSTFIELDS, $this->requestData);
    }
    if($this->userPass) {
      if(!strstr($_url, "https://")) {
        throw new ExceptionApi("Basic authentication requires the endpoint to be https");
      }
      $this->handle->setOption(CURLOPT_HTTPAUTH, CURLAUTH_ANY);
      $this->handle->setOption(CURLOPT_USERPWD, $this->userPass);
      //$this->_headers[] = "Authorization: Basic " . \iota\converter::base64_encode($this->_user . ":" . $this->_pass);
    }
    $this->handle->setOption(CURLOPT_HTTPHEADER, $this->headers);
    $_ret = $this->handle->exec();
    // set Defaults for new fetch
    $this->method('GET');
    $this->requestData = null;
    $this->query       = [];
    $this->route       = null;

    return $_ret;
  }

  /**
   * @return array|false
   */
  public function getHandleStatus(): array|false {
    return $this->handle->getStatus();
  }

  /**
   * @return mixed
   */
  public function getHandleInfo(): mixed {
    return $this->handle->getInfo();
  }

  /**
   * @return string|null
   */
  public function getHandleContent(): string|null {
    return $this->handle->getContent();
  }

  /**
   * @param int $timeout
   *
   * @return string|ResponseError
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function fetchBinary(int $timeout = 0): string|ResponseError {
    $this->headers[] = 'accept: application/octet-stream';
    $this->headers[] = 'content-type: application/octet-stream';
    $this->fetch($timeout);
    $content = $this->handle->getContent();
    if(Converter::isBinary($content)) {
      return $content;
    }

    return $this->JSONHandle($content);
  }

  /**
   * @param int $timeout
   *
   * @return mixed
   * @throws ExceptionApi
   * @throws ExceptionHelper
   */
  public function fetchJSON(int $timeout = 30): mixed {
    $this->headers[] = 'accept: application/json';
    $this->headers[] = 'content-type: application/json';
    //
    $this->fetch($timeout);
    $content = $this->handle->getContent();
    if($content === null || !Converter::isJSON($content)) {
      if($this->settings['jsonException']) {
        throw new ExceptionApi("No JSON content to fetch");
      }
      else {
        return $content;
      }
    }

    return $this->JSONHandle($content);
  }

  /**
   * @param int $timeout
   *
   * @return array
   * @throws ExceptionApi|ExceptionHelper
   */
  public function fetchArray(int $timeout = 30): array {
    $_ret = $this->fetchJSON($timeout);

    return (new JSON($_ret))->__toArray();
  }

  /**
   * @param int $timeout
   *
   * @return array|bool
   * @throws ExceptionApi
   */
  public function fetchStatus(int $timeout = 30): array|bool {
    $this->fetch($timeout);

    return $this->handle->getStatus();
  }

  /**
   * @param JSON|string $content
   *
   * @return mixed
   * @throws ExceptionHelper
   */
  private function JSONHandle(JSON|string $content): mixed {
    $content = new JSON($content);
    $check   = $content->__toArray();
    switch(array_key_first($check)) {
      case $this->settings['jsonError']:
        return new ResponseError($check[$this->settings['jsonError']]);
      case $this->settings['jsonData']:
        if(isset($this->callback)) {
          return new $this->callback($check[$this->settings['jsonData']]);
        }
        break;
    }
    $this->callback = null;
    $this->settings = [
      'jsonException' => true,
      'jsonData'      => 'data',
      'jsonError'     => 'error',
    ];

    return $content;
  }
}