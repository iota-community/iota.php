<?php namespace IOTA\Util;

use IOTA\Api\v1\ResponseInfo;
use IOTA\Exception\Util as ExceptionUtil;
use IOTA\Exception\Api as ExceptionApi;
use IOTA\Exception\Helper as ExceptionHelper;

/**
 * Class Network
 *
 * @package      IOTA\Helper
 * @author       StefanBraun @IOTAphp
 * @copyright    Copyright (c) 2021, StefanBraun
 */
class Network {
  /**
   * @var string
   */
  public string $API_ENDPOINT;
  /**
   * @var string
   */
  public string $API_ENDPOINT_basePath;
  /**
   * @var string
   */
  public string $EXPLORER;
  /**
   * @var string
   */
  public string $bech32HRP;
  /**
   *
   */
  const explorerUrl = 'https://explorer.iota.org/';
  /**
   *
   */
  const basePath = 'api/v1/';
  /**
   *
   */
  const bech32HRP = [
    'atoi1',
    'iota',
  ];
  const alias     = [
    [
      'api.lb-0.testnet.chrysalis2.com',
      'testnet',
      'test',
    ],
    [
      'chrysalis-nodes.iota.org',
      'mainnet',
      'main',
    ],
  ];
  /**
   *
   */
  const testnet = [
    'API_ENDPOINT'          => 'https://' . self::alias[0][0],
    'API_ENDPOINT_basePath' => self::basePath,
    'EXPLORER'              => self::explorerUrl . 'testnet',
    'bech32HRP'             => self::bech32HRP[0],
  ];
  /**
   *
   */
  const mainnet = [
    'API_ENDPOINT'          => 'https://' . self::alias[1][0],
    'API_ENDPOINT_basePath' => self::basePath,
    'EXPLORER'              => self::explorerUrl . 'mainnet',
    'bech32HRP'             => self::bech32HRP[1],
  ];

  /**
   * Network constructor.
   *
   * @param string|array|Network $input
   *
   * @throws ExceptionApi
   * @throws ExceptionHelper
   * @throws ExceptionUtil
   */
  public function __construct(string|array|Network $input = self::testnet) {
    if($input instanceof Network) {
      return $this->parseNetwork($input);
    }
    if(is_string($input)) {
      if(strstr($input, "https://") || strstr($input, "http://")) {
        return $this->parseNetwork(self::fromUrl($input));
      }
      $this->pareName($input);

      return $this;
    }
    $this->parseArray($input);

    return $this;
  }

  /**
   * @param string      $nodeApiUrl
   * @param string|null $basePath
   * @param string|null $explorerUrl
   * @param string|null $bech32HRP
   *
   * @return Network
   * @throws ExceptionApi
   * @throws ExceptionHelper
   * @throws ExceptionUtil
   */
  static public function fromNode(string $nodeApiUrl, ?string $basePath = self::basePath, ?string $explorerUrl = null, ?string $bech32HRP = null): Network {
    // check Communication
    $ApiCaller = (new ApiCaller($nodeApiUrl))->basePath($basePath);
    try {
      $ret = $ApiCaller->route('info')
                       ->callback(ResponseInfo::class)
                       ->fetchJSON();
    }
    catch(ExceptionApi) {
      $ret = null;
    }
    // need ResponseInfo
    if(!$ret instanceof ResponseInfo) {
      throw new ExceptionUtil("Can not connect to '$nodeApiUrl' with basePath '$basePath'");
    }
    //set HRP
    $bech32HRP = $bech32HRP ?? $ret->bech32HRP;
    // set explorer url
    $explorerUrl = $explorerUrl ?? self::explorerUrl . ($bech32HRP == 'iota' ? 'mainnet' : 'testnet');

    // return Network
    return new Network([
      'API_ENDPOINT'          => $nodeApiUrl,
      'API_ENDPOINT_basePath' => $basePath,
      'EXPLORER'              => $explorerUrl,
      'bech32HRP'             => $bech32HRP,
    ]);
  }

  /**
   * @param $nodeApiUrl
   *
   * @return Network
   * @throws ExceptionApi
   * @throws ExceptionHelper
   * @throws ExceptionUtil
   */
  static public function fromUrl($nodeApiUrl): Network {
    return self::fromNode($nodeApiUrl);
  }

  /**
   * @param Network $network
   *
   * @return $this
   */
  protected function parseNetwork(Network $network): self {
    $this->API_ENDPOINT          = $network->API_ENDPOINT;
    $this->API_ENDPOINT_basePath = $network->API_ENDPOINT_basePath;
    $this->EXPLORER              = $network->EXPLORER;
    $this->bech32HRP             = $network->bech32HRP;

    return $this;
  }

  /**
   * @param array $array
   * @param array $fallback
   */
  protected function parseArray(array $array, array $fallback = self::testnet): void {
    $this->API_ENDPOINT          = $array['API_ENDPOINT'] ?? $array[0] ?? $fallback['API_ENDPOINT'];
    $this->API_ENDPOINT_basePath = $array['API_ENDPOINT_basePath'] ?? $array[1] ?? $fallback['API_ENDPOINT_basePath'];
    $this->EXPLORER              = $array['EXPLORER'] ?? $array[2] ?? $fallback['EXPLORER'];
    $this->bech32HRP             = $array['bech32HRP'] ?? $array[3] ?? $fallback['bech32HRP'];
  }

  /**
   * @param string $name
   *
   * @throws ExceptionUtil
   */
  protected function pareName(string $name): void {
    $name = strtolower($name);
    //
    if(in_array($name, self::alias[0])) {
      $this->parseArray(self::testnet);
    }
    elseif(in_array($name, self::alias[1])) {
      $this->parseArray(self::mainnet);
    }
    else {
      throw new ExceptionUtil("Unknown network '$name'");
    }
  }
}