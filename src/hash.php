<?php namespace iota;
/**
 * Class api
 *
 * @package iota
 */
class hash {
  /**
   * @var string
   */
  public string $ALGO = "sha512";
  /**
   * @var string
   */
  public ?string $KEY = null;
  /**
   * @var int
   */
  public int $HMAC = 0;
  /**
   * @var HashContext
   */
  protected $_handle;
  /**
   * @var bool
   */
  private $_isFinal = false;

  /**
   * hash constructor.
   *
   * @param string|null $algo
   * @param string|null $_key
   * @param int|null    $HMAC
   *
   * @throws exception\hash
   */
  public function __construct(string $algo = null, string $_key = null, int $HMAC = null) {
    $algo = \strtolower($algo) ?? $this->ALGO;
    if(!in_array($algo, $this->algos())) {
      throw new \iota\exception\hash("unknown hashing algorithms {$algo}");
    }
    $this->_handle = \hash_init($algo, $HMAC ?? $this->HMAC, $_key ?? $this->KEY);
  }

  /**
   * @param string $data
   *
   * @return $this
   * @throws exception\hash
   */
  public function update(string $data): self {
    if($this->_isFinal) {
      throw new \iota\exception\hash("hash already final");
    }
    \hash_update($this->_handle, $data);

    return $this;
  }

  /**
   * @param bool $_binary
   *
   * @return string
   */
  public function digest(bool $_binary = false) {
    $this->_isFinal = true;

    return \hash_final($this->_handle, $_binary);
  }

  /**
   * @param string|null $_key
   * @param int|null    $HMAC
   *
   * @return hash
   * @throws exception\hash
   */
  static public function sha512(string $_key = null, int $HMAC = null): \iota\hash {
    return new \iota\hash("sha512", $_key, $HMAC);
  }

  /**
   * @param string|null $_key
   *
   * @return hash
   * @throws exception\hash
   */
  static public function hmacSha512(string $_key = null): \iota\hash {
    return self::sha512($_key, HASH_HMAC);
  }

  /**
   * @param string|null $_key
   * @param int|null    $HMAC
   *
   * @return hash
   * @throws exception\hash
   */
  static public function sha256(string $_key = null, int $HMAC = null): \iota\hash {
    return new \iota\hash("sha256", $_key, $HMAC);
  }

  /**
   * @param $data
   *
   * @return string
   */
  static public function blake2b_sum256($data) {
    return  \sodium_crypto_generichash($data);
    //return (new \iota\crypto\Blake2b(32))->hash($data);
  }

  /**
   * @return array
   */
  static public function algos(): array {
    return \hash_algos();
  }

  /**
   * @param string $algo
   * @param string $_password
   * @param string $salt
   * @param int    $_iterations
   * @param int    $_keyLength
   * @param false  $_binary
   *
   * @return string
   * @throws exception\hash
   */
  static public function pbkdf2(string $algo, string $_password, string $salt, int $_iterations = 2048, int $_keyLength = 128, $_binary = false): string {
    $algo = \strtolower($algo);
    if(!\in_array($algo, self::algos())) {
      throw new \iota\exception\hash("unknown hashing algorithms {$algo}");
    }

    return \hash_pbkdf2($algo, $_password, $salt, $_iterations, $_keyLength, $_binary);
  }

  /**
   * @param string $_password
   * @param string $salt
   * @param int    $_iterations
   * @param int    $_keyLength
   * @param false  $_binary
   *
   * @return string
   * @throws exception\hash
   */
  static public function pbkdf2Sha512(string $_password, string $salt, int $_iterations = 2048, int $_keyLength = 128, $_binary = false): string {
    return self::pbkdf2("sha512", $_password, $salt, $_iterations, $_keyLength, $_binary);
  }
}