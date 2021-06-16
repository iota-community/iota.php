<?php namespace iota;
/**
 * Class api
 *
 * @package iota
 */
class api {
  /**
   * api constructor.
   *
   * @param client $_client
   */
  public function __construct(protected \iota\client $_client) {
  }

  /**
   * @param array $array
   *
   * @return false|mixed
   * @throws \Exception
   */
  public function fetch(array $array = []) {
    return (new \iota\api_fetchBuilder($array))->fetch($this->_client);
  }
}
/**
 * Class api_fetchBuilder
 *
 * @package iota
 */
class api_fetchBuilder {
  /**
   * @var string
   */
  public string $fetch = 'Array';
  /**
   * @var string
   */
  public string $method = 'get';
  /**
   * @var string
   */
  public string $route;
  /**
   * @var array
   */
  public array $query = [];
  /**
   * @var helper\json|null
   */
  public ?\iota\helper\json $requestData = null;
  /**
   * @var mixed
   */
  public mixed $return = null;

  /**
   * api_fetchBuilder constructor.
   *
   * @param array $array
   */
  public function __construct(array $array = []) {
    foreach($array as $_k => $_v) {
      if(\property_exists($this, $_k)) {
        $this->{$_k} = $_v;
      }
    }
  }

  /**
   * @param client $client
   *
   * @return false|mixed
   * @throws \Exception
   */
  public function fetch(\iota\client $client) {
    if(\method_exists($client, 'fetch' . $this->fetch)) {
      $_ret = \call_user_func([
        $client,
        'fetch' . $this->fetch,
      ], $this->method, $this->route . (\count($this->query) > 0 ? '?' . \http_build_query($this->query) : ''), $this->requestData);
      switch(\gettype($this->return)) {
        case 'string' :
          return new $this->return($_ret);
        default;
          return $_ret;
      }
    }
    throw new \Exception("unknown function client->fetch{$this->fetch} ");
  }
}