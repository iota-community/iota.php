<?php namespace iota\helper;
/**
 * Class curl
 *
 * @package iota\helper
 */
class curl {
  /**
   * @var bool
   */
  private $_handle = false;
  /**
   * @var null
   */
  private $_header = null;
  /**
   * @var null
   */
  private $_options = null;
  /**
   * @var null
   */
  private $_status = null;
  /**
   * @var null
   */
  private $_caseless = null;
  /**
   * @var null
   */
  private $_followed = null;
  /**
   * @var null
   */
  private $_content = null;

  /**
   * curl constructor.
   *
   * @param string $_url
   *
   * @throws \Exception
   */
  function __construct($_url = 'http://127.0.0.1') {
    if(!\extension_loaded('curl')) {
      throw new \Exception("'curl' extension not loaded!");

      return false;
    }
    if($this->getActive()) {
      throw new \Exception("curl is currently connected");

      return false;
    }
    $this->_handle = \curl_init();
    $this->setOption(CURLOPT_URL, $_url);
    $this->setOption(CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    $this->setOption(CURLOPT_HEADER, true);
    $this->setOption(CURLOPT_RETURNTRANSFER, true);
    $this->setOption(CURLOPT_CONNECTTIMEOUT, 0);
    $this->setOption(CURLOPT_TIMEOUT, 0);
    //$this->setOption(CURLOPT_COOKIESESSION, true);
    //$this->setOption(CURLOPT_COOKIEJAR, 'cookie-name');

    if(\strstr($_url, "https://")) {
      $this->setOption(CURLOPT_SSL_VERIFYPEER, 0);
      $this->setOption(CURLOPT_SSL_VERIFYHOST, 0);
    }

    return true;
  }

  /**
   *
   */
  function __destruct() {
    if(!$this->getHandle()) {
      return true;
    }
    \curl_close($this->_handle);
    $this->_handle = null;

    return true;
  }

  /**
   * @return bool
   */
  public function checkHandle() {
    if($this->getHandle() === false) {
      return false;
    }

    return true;
  }

  /**
   * @return bool
   */
  public function getHandle() {
    return $this->_handle;
  }

  /**
   * @return string
   */
  public function exec() {
    $_retValue               = \curl_exec($this->_handle);
    $this->_status           = \curl_getinfo($this->_handle);
    $this->_status['_errno'] = \curl_errno($this->_handle);
    $this->_status['_error'] = \curl_error($this->_handle);
    $this->_header           = null;
    if($this->_status['_errno']) {
      return '';
    }
    if($this->getOption(CURLOPT_HEADER)) {
      $this->_followed = [];
      $rv              = $_retValue;
      while(\count($this->_followed) <= $this->_status['redirect_count']) {
        $_array            = \preg_split("/(\r\n){2,2}/", $rv, 2);
        $this->_followed[] = $_array[0];
        $rv                = $_array[1];
      }
      $this->parseHeader($_array[0]);
      $this->_content = $_array[1];

      return $_array[1];
    }
    else {
      $this->_content = $_retValue;

      return $_retValue;
    }
  }

  /**
   * @return bool
   */
  public function getActive() {
    return \is_resource($this->_handle);
  }

  /**
   * @return null
   */
  public function getContent() {
    return $this->_content;
  }

  /**
   * @param null $_header
   *
   * @return bool|null
   */
  public function getHeader($_header = null) {
    if(empty($this->_header)) {
      return false;
    }
    if(empty($_header)) {
      return $this->_header;
    }
    else {
      if(isset($this->_caseless[$_header])) {
        return $this->_header[$this->_caseless[$_header]][0];
      }
      else {
        return false;
      }
    }
  }

  /**
   * @param $option
   *
   * @return bool
   */
  public function getOption($option) {
    if(isset($this->_options[$option])) {
      return $this->_options[$option];
    }

    return false;
  }

  /**
   * @return bool
   */
  public function hasError() {
    if(isset($this->_status['_error'])) {
      return (empty($this->_status['_error']) ? false : $this->_status['_error']);
    }
    else {
      return false;
    }
  }

  /**
   * @param $_header
   *
   * @return bool
   */
  public function parseHeader($_header) {
    $this->_caseless = [];
    $_array          = \preg_split("/(\r\n)+/", $_header);
    if(\preg_match('/^HTTP/', $_array[0])) {
      $_array = \array_slice($_array, 1);
    }
    foreach($_array as $HeaderString) {
      $_headerStringArray = \preg_split("/\s*:\s*/", $HeaderString, 2);
      $_caselessTag       = \strtoupper($_headerStringArray[0]);
      if(!isset($this->_caseless[$_caselessTag])) {
        $this->_caseless[$_caselessTag] = $_headerStringArray[0];
      }
      $this->_header[$this->_caseless[$_caselessTag]][] = $_headerStringArray[1];
    }

    return true;
  }

  /**
   * @param null $_theField
   *
   * @return bool|null
   */
  public function getStatus($_theField = null) {
    if(empty($_theField)) {
      return $this->_status;
    }
    else {
      if(isset($this->_status[$_theField])) {
        return $this->_status[$_theField];
      }
      else {
        return false;
      }
    }
  }

  /**
   * @param $option
   * @param $value
   */
  public function setOption($option, $value) {
    \curl_setopt($this->_handle, $option, $value);
    $this->_options[$option] = $value;
  }

  /**
   * @param $postString
   *
   * @return array
   */
  public function &fromPostString(&$postString) {
    $_ret    = [];
    $_fields = \explode('&', $postString);
    foreach($_fields as $aField) {
      $e           = explode('=', $aField);
      $_ret[$e[0]] = urldecode($e[1]);
    }

    return $_ret;
  }

  /**
   * @param array $data
   * @param null  $_name
   *
   * @return bool|string
   */
  public function &asPostString(array &$data, $_name = null) {
    $_postString = '';
    $_prefix     = $_name;
    if(is_array($data)) {
      foreach($data as $Key => $Value) {
        if($_prefix === null) {
          $_postString .= '&' . curl::asPostString($Value, $Key);
        }
        else {
          $_postString .= '&' . curl::asPostString($Value, $_prefix . '[' . $Key . ']');
        }
      }
    }
    else {
      $_postString .= '&' . \urlencode((string)$_prefix) . '=' . \urlencode($data);
    }
    $_res = \substr($_postString, 1);

    return $_res;
  }

  /**
   * @return array
   */
  public function getFollowedHeaders() {
    $_headers = [];
    if($this->_followed) {
      foreach($this->_followed as $_aHeader) {
        $_headers[] = \explode("\r\n", $_aHeader);
      }

      return $_headers;
    }

    return $_headers;
  }

  /**
   * @param null $_opt
   *
   * @return mixed
   */
  public function getInfo($_opt = null) {
    return \curl_getinfo($this->_handle, $_opt);
  }
}