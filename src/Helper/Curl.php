<?php namespace IOTA\Helper;

use CurlHandle;
use IOTA\Exception\Helper as ExceptionHelper;

/**
 * Class Curl
 *
 * @package      IOTA\Helper
 * @author       StefanBraun
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Curl {
  /**
   * @var CurlHandle
   */
  private CurlHandle $handle;
  /**
   * @var array
   */
  private array $header;
  /**
   * @var array
   */
  private array $options;
  /**
   * @var array
   */
  private array $status = [];
  /**
   * @var array
   */
  private array $caseless;
  /**
   * @var string|null
   */
  private ?string $content = null;

  /**
   * Curl constructor.
   *
   * @param string $_url
   *
   * @throws ExceptionHelper
   */
  function __construct(string $_url = 'http://127.0.0.1') {
    if(!extension_loaded('curl')) {
      throw new ExceptionHelper("'curl' extension not loaded!");
    }
    if($this->getActive()) {
      throw new ExceptionHelper("curl is currently connected");
    }
    $this->handle = curl_init();
    $this->setOption(CURLOPT_URL, $_url);
    $this->setOption(CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    $this->setOption(CURLOPT_HEADER, true);
    $this->setOption(CURLOPT_RETURNTRANSFER, true);
    $this->setOption(CURLOPT_CONNECTTIMEOUT, 0);
    $this->setOption(CURLOPT_TIMEOUT, 0);
    $this->setOption(CURLOPT_NOPROGRESS, true);
    //$this->setOption(CURLOPT_COOKIESESSION, true);
    //$this->setOption(CURLOPT_COOKIEJAR, 'cookie-name');
    if(strstr($_url, "https://")) {
      $this->setOption(CURLOPT_SSL_VERIFYPEER, 0);
      $this->setOption(CURLOPT_SSL_VERIFYHOST, 0);
    }

    return true;
  }

  /**
   * @return bool
   */
  public function checkHandle(): bool {
    return is_resource($this->getHandle());
  }

  /**
   * @return CurlHandle
   */
  public function getHandle(): CurlHandle {
    return $this->handle;
  }

  /**
   * @return string
   */
  public function exec(): string {
    $_retValue              = curl_exec($this->handle);
    $this->status           = curl_getinfo($this->handle);
    $this->status['_errno'] = curl_errno($this->handle);
    $this->status['_error'] = curl_error($this->handle);
    if($this->status['_errno']) {
      return '';
    }
    if($this->getOption(CURLOPT_HEADER)) {
      $followed = [];
      $rv       = $_retValue;
      $_array   = [];
      while(count($followed) <= $this->status['redirect_count']) {
        $_array     = preg_split("/(\r\n){2}/", $rv, 2);
        $followed[] = $_array[0];
        $rv         = $_array[1];
      }
      $this->parseHeader($_array[0]);
      $this->content = $_array[1];

      return $_array[1];
    }
    else {
      $this->content = $_retValue;

      return $_retValue;
    }
  }

  /**
   * @return bool
   */
  public function getActive(): bool {
    return isset($this->handle);
  }

  /**
   * @return string|null
   */
  public function getContent(): ?string {
    return $this->content;
  }

  /**
   * @param null $_header
   *
   * @return mixed
   */
  public function getHeader($_header = null): mixed {
    if(empty($this->header)) {
      return false;
    }
    if(empty($_header)) {
      return $this->header;
    }
    else {
      if(isset($this->caseless[$_header])) {
        return $this->header[$this->caseless[$_header]][0];
      }
      else {
        return false;
      }
    }
  }

  /**
   * @param $option
   *
   * @return mixed
   */
  public function getOption($option): mixed {
    return $this->options[$option] ?? false;
  }

  /**
   * @return bool
   */
  public function hasError(): bool {
    if(isset($this->status['_error'])) {
      return (empty($this->status['_error']) ? false : $this->status['_error']);
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
  public function parseHeader($_header): bool {
    $this->caseless = [];
    $_array         = preg_split("/(\r\n)+/", $_header);
    if(preg_match('/^HTTP/', $_array[0])) {
      $_array = array_slice($_array, 1);
    }
    foreach($_array as $HeaderString) {
      $_headerStringArray = preg_split("/\s*:\s*/", $HeaderString, 2);
      $_caselessTag       = strtoupper($_headerStringArray[0]);
      if(!isset($this->caseless[$_caselessTag])) {
        $this->caseless[$_caselessTag] = $_headerStringArray[0];
      }
      $this->header[$this->caseless[$_caselessTag]][] = $_headerStringArray[1];
    }

    return true;
  }

  /**
   * @param null $_theField
   *
   * @return array|false
   */
  public function getStatus($_theField = null): array|false {
    return empty($_theField) ? $this->status : $this->status[$_theField] ?? false;
  }

  /**
   * @param $option
   * @param $value
   */
  public function setOption($option, $value): void {
    curl_setopt($this->handle, $option, $value);
    $this->options[$option] = $value;
  }

  /**
   * @param null $_opt
   *
   * @return mixed
   */
  public function getInfo($_opt = null): mixed {
    return curl_getinfo($this->handle, $_opt);
  }
}