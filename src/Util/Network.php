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
  public string $NAME;
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
   * @var string
   */
  public string $faucet_API_ENDPOINT;
  /**
   * @var string
   */
  public string $faucet_API_ENDPOINT_basePath;
  /**
   * @var string
   */
  public string $faucet_address;
  const default = self::comnet;
  /**
   *
   */
  const alias = [
    [
      'api.lb-0.h.chrysalis-devnet.iota.cafe',
      'devnet',
      'chrysalis-devnet',
      'test',
    ],
    [
      'chrysalis-nodes.iota.org',
      'mainnet',
      'main',
    ],
    [
      'iota-node.usegate.online:444',
      'comnet',
      'comnet1',
      'com',
    ],
  ];
  /**
   *
   */
  const devnet = [
    'NAME'                         => 'devnet',
    'API_ENDPOINT'                 => 'https://api.lb-0.h.chrysalis-devnet.iota.cafe',
    'API_ENDPOINT_basePath'        => 'api/v1/',
    'EXPLORER'                     => 'https://explorer.iota.org/devnet/',
    'bech32HRP'                    => 'atoi1',
    'faucet_API_ENDPOINT'          => 'https://faucet.chrysalis-devnet.iota.cafe',
    'faucet_API_ENDPOINT_basePath' => 'api/plugins/faucet',
    'faucet_address'               => 'atoi1qrk69lxuxljdgeqt7tucvtdfk3hrvrly7rzz65w57te6drf3expsj3gqrf9',
  ];
  /**
   *
   */
  const comnet = [
    'NAME'                         => 'comnet1',
    'API_ENDPOINT'                 => 'https://iota-node.usegate.online:444',
    'API_ENDPOINT_basePath'        => 'api/v1/',
    'EXPLORER'                     => 'https://iota-node.usegate.online:444/explorer/',
    'bech32HRP'                    => 'atoi1',
    'faucet_API_ENDPOINT'          => 'https://comnet.tanglekit.de',
    'faucet_API_ENDPOINT_basePath' => 'api',
    'faucet_address'               => 'atoi1qzh6ud4kq52700n7ulxyzmh32r376nhqa56gluq6j3ym3jh6fx82yyr846r',
  ];
  /**
   *
   */
  const mainnet = [
    'NAME'                         => 'mainnet',
    'API_ENDPOINT'                 => 'https://chrysalis-nodes.iota.org',
    'API_ENDPOINT_basePath'        => 'api/v1/',
    'EXPLORER'                     => 'https://explorer.iota.org/mainnet/',
    'bech32HRP'                    => 'iota',
    'faucet_API_ENDPOINT'          => '',
    'faucet_API_ENDPOINT_basePath' => '',
    'faucet_address'               => '',
  ];

  /**
   * @param string|array|Network|null $input
   *
   * @throws ExceptionApi
   * @throws ExceptionHelper
   * @throws ExceptionUtil
   */
  public function __construct(string|array|Network|null $input = null) {
    if($input === null) {
      $input = self::default;
    }
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
  static public function fromNode(string $nodeApiUrl, ?string $basePath = 'api/v1/', ?string $explorerUrl = null): Network {
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
    $name = ($ret->bech32HRP == 'iota' ? 'mainnet' : 'devnet/comnet');
    // set explorer url
    $explorerUrl = $explorerUrl ?? 'https://explorer.iota.org/' . $name;

    // return Network
    return new Network([
      'NAME'                  => $name,
      'API_ENDPOINT'          => $nodeApiUrl,
      'API_ENDPOINT_basePath' => $basePath,
      'EXPLORER'              => $explorerUrl,
      'bech32HRP'             => $ret->bech32HRP,
      //'faucet_API_ENDPOINT'          => $faucet_API_ENDPOINT,
      //'faucet_API_ENDPOINT_basePath' => $faucet_API_ENDPOINT_basePath,
      //'faucet_address' => $faucet_address,
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
    $this->NAME                         = $network->NAME;
    $this->API_ENDPOINT                 = $network->API_ENDPOINT;
    $this->API_ENDPOINT_basePath        = $network->API_ENDPOINT_basePath;
    $this->EXPLORER                     = $network->EXPLORER;
    $this->bech32HRP                    = $network->bech32HRP;
    $this->faucet_API_ENDPOINT          = $network->faucet_API_ENDPOINT;
    $this->faucet_API_ENDPOINT_basePath = $network->faucet_API_ENDPOINT_basePath;
    $this->faucet_address               = $network->faucet_address;

    return $this;
  }

  /**
   * @param array $array
   * @param array $fallback
   */
  protected function parseArray(array $array, array $fallback = self::default): void {
    $this->NAME                         = $array['NAME'] ?? $array[0] ?? $fallback['NAME'];
    $this->API_ENDPOINT                 = $array['API_ENDPOINT'] ?? $array[1] ?? $fallback['API_ENDPOINT'];
    $this->API_ENDPOINT_basePath        = $array['API_ENDPOINT_basePath'] ?? $array[2] ?? $fallback['API_ENDPOINT_basePath'];
    $this->EXPLORER                     = $array['EXPLORER'] ?? $array[3] ?? $fallback['EXPLORER'];
    $this->bech32HRP                    = $array['bech32HRP'] ?? $array[4] ?? $fallback['bech32HRP'];
    $this->faucet_API_ENDPOINT          = $array['faucet_API_ENDPOINT'] ?? $array[5] ?? $fallback['faucet_API_ENDPOINT'];
    $this->faucet_API_ENDPOINT_basePath = $array['faucet_API_ENDPOINT_basePath'] ?? $array[6] ?? $fallback['faucet_API_ENDPOINT_basePath'];
    $this->faucet_address               = $array['faucet_address'] ?? $array[7] ?? $fallback['faucet_address'];
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
      $this->parseArray(self::devnet);
    }
    elseif(in_array($name, self::alias[1])) {
      $this->parseArray(self::mainnet);
    }
    elseif(in_array($name, self::alias[2])) {
      $this->parseArray(self::comnet);
    }
    else {
      throw new ExceptionUtil("Unknown network '$name'");
    }
  }

  /**
   * @param string $messageId
   *
   * @return string
   */
  public function getExplorerUrlMessage(string $messageId): string {
    return $this->EXPLORER . "message/" . $messageId;
  }
}