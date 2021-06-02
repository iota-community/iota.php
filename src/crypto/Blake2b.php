<?php namespace iota\crypto;
/**
 * Class Blake2b
 *
 * @package iota\crypto
 */
class Blake2b {
  /**
   * Blake2b constructor.
   *
   * @param int $size
   */
  public function __construct($size = 32) {
    $this->size  = $size;
    $this->iv    = [];
    $this->iv[0] = $this->_new64(0x6a09e667, 0xf3bcc908);
    $this->iv[1] = $this->_new64(0xbb67ae85, 0x84caa73b);
    $this->iv[2] = $this->_new64(0x3c6ef372, 0xfe94f82b);
    $this->iv[3] = $this->_new64(0xa54ff53a, 0x5f1d36f1);
    $this->iv[4] = $this->_new64(0x510e527f, 0xade682d1);
    $this->iv[5] = $this->_new64(0x9b05688c, 0x2b3e6c1f);
    $this->iv[6] = $this->_new64(0x1f83d9ab, 0xfb41bd6b);
    $this->iv[7] = $this->_new64(0x5be0cd19, 0x137e2179);
  }

  /**
   * @param $data
   *
   * @return string
   */
  public function hash($data): string {
    $_ctx = $this->_init(null, $this->size);
    $this->_update($_ctx, $data, \strlen($data));

    return \substr($this->_finish($_ctx), 0, $this->size);
  }

  /**
   * @param $high
   * @param $low
   *
   * @return array
   */
  private function _new64($high, $low): array {
    $_i64    = [];
    $_i64[0] = $high & 0xffffffff;
    $_i64[1] = $low & 0xffffffff;

    return $_i64;
  }

  /**
   * @param $num
   *
   * @return array
   */
  private function _to64($num): array {
    return $this->_new64(0, $num & 0xffffffff);
  }

  /**
   * @param $x
   * @param $y
   *
   * @return array
   */
  private function _add64($x, $y): array {
    $_l = ($x[1] + $y[1]) & 0xffffffff;
    if(PHP_INT_SIZE > 4) {
      $_c = $_l < $x[1] ? 1 : 0;
    }
    else {
      if((($x[1] < 0 && $y[1] < 0)) || (($x[1] < 0 || $y[1] < 0) && $_l >= 0)) {
        $_c = 1;
      }
      else {
        $_c = 0;
      }
    }

    return $this->_new64($x[0] + $y[0] + $_c, $_l);
  }

  /**
   * @param $x
   * @param $y
   * @param $z
   *
   * @return array
   */
  private function _add364($x, $y, $z): array {
    return $this->_add64($x, $this->_add64($y, $z));
  }

  /**
   * @param $x
   * @param $y
   *
   * @return array
   */
  private function _xor64($x, $y): array {
    return $this->_new64($x[0] ^ $y[0], $x[1] ^ $y[1]);
  }

  /**
   * @param $x
   * @param $s
   *
   * @return int|mixed
   */
  private function _rs($x, $s): mixed {
    if($s) {
      return ($x >> $s) & ~(1 << (8 * PHP_INT_SIZE - 1) >> ($s - 1));
    }

    return $x;
  }

  /**
   * @param $x
   * @param $c
   *
   * @return array
   */
  private function _rotr64($x, $c): array {

    $_h0 = 0;
    $_l0 = 0;
    $c  = 64 - $c;
    if($c < 32) {
      $_h0 = ($x[0] << $c) | $this->_rs($x[1] & ((1 << $c) - 1) << (32 - $c), 32 - $c);
      $_l0 = $x[1] << $c;
    }
    else {
      $_h0 = $x[1] << ($c - 32);
    }
    $h1 = 0;
    $l1 = 0;
    $c1 = 64 - $c;
    if($c1 < 32) {
      $h1 = $this->_rs($x[0], $c1);
      $l1 = $this->_rs($x[1], $c1) | ($x[0] & ((1 << $c1) - 1)) << (32 - $c1);
    }
    else {
      $l1 = $this->_rs($x[0], $c1 - 32);
    }

    return $this->_new64($_h0 | $h1, $_l0 | $l1);
  }

  /**
   * @param $x
   *
   * @return float|int|mixed
   */
  private function _flatten64($x): mixed {
    return ($x[0] * 4294967296 + $x[1]);
  }

  /**
   * @param $x
   * @param $i
   *
   * @return array
   */
  private function _load64($x, $i): array {
    $_l = $x[$i] | ($x[$i + 1] << 8) | ($x[$i + 2] << 16) | ($x[$i + 3] << 24);
    $_h = $x[$i + 4] | ($x[$i + 5] << 8) | ($x[$i + 6] << 16) | ($x[$i + 7] << 24);

    return $this->_new64($_h, $_l);
  }

  /**
   * @var \int[][]
   */
  private $sigma = [
    [
      0,
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      8,
      9,
      10,
      11,
      12,
      13,
      14,
      15,
    ],
    [
      14,
      10,
      4,
      8,
      9,
      15,
      13,
      6,
      1,
      12,
      0,
      2,
      11,
      7,
      5,
      3,
    ],
    [
      11,
      8,
      12,
      0,
      5,
      2,
      15,
      13,
      10,
      14,
      3,
      6,
      7,
      1,
      9,
      4,
    ],
    [
      7,
      9,
      3,
      1,
      13,
      12,
      11,
      14,
      2,
      6,
      5,
      10,
      4,
      0,
      15,
      8,
    ],
    [
      9,
      0,
      5,
      7,
      2,
      4,
      10,
      15,
      14,
      1,
      11,
      12,
      6,
      8,
      3,
      13,
    ],
    [
      2,
      12,
      6,
      10,
      0,
      11,
      8,
      3,
      4,
      13,
      7,
      5,
      15,
      14,
      1,
      9,
    ],
    [
      12,
      5,
      1,
      15,
      14,
      13,
      4,
      10,
      0,
      7,
      6,
      3,
      9,
      2,
      8,
      11,
    ],
    [
      13,
      11,
      7,
      14,
      12,
      1,
      3,
      9,
      5,
      0,
      15,
      4,
      8,
      6,
      2,
      10,
    ],
    [
      6,
      15,
      14,
      9,
      11,
      3,
      0,
      8,
      12,
      2,
      13,
      7,
      1,
      4,
      10,
      5,
    ],
    [
      10,
      2,
      8,
      4,
      7,
      6,
      1,
      5,
      15,
      11,
      9,
      14,
      3,
      12,
      13,
      0,
    ],
    [
      0,
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      8,
      9,
      10,
      11,
      12,
      13,
      14,
      15,
    ],
    [
      14,
      10,
      4,
      8,
      9,
      15,
      13,
      6,
      1,
      12,
      0,
      2,
      11,
      7,
      5,
      3,
    ],
  ];

  /**
   * @return array
   */
  private function _context(): array {
    $ctx    = [];
    $ctx[0] = []; // h
    $ctx[1] = []; // t
    $ctx[2] = []; // f
    $ctx[3] = []; // buf
    $ctx[4] = 0;  // buflen
    for($i = 8; $i--;)
      $ctx[0][$i] = $this->iv[$i];
    for($i = 256; $i--;)
      $ctx[3][$i] = 0;
    $zero      = $this->_new64(0, 0);
    $ctx[1][0] = $zero;
    $ctx[1][1] = $zero;
    $ctx[2][0] = $zero;
    $ctx[2][1] = $zero;

    return $ctx;
  }

  /**
   * @param $v
   * @param $m
   * @param $r
   * @param $i
   * @param $a
   * @param $b
   * @param $c
   * @param $d
   */
  private function _G(&$v, $m, $r, $i, $a, $b, $c, $d): void {
    $v[$a] = $this->_add364($v[$a], $v[$b], $m[$this->sigma[$r][2 * $i]]);
    $v[$d] = $this->_rotr64($this->_xor64($v[$d], $v[$a]), 32);
    $v[$c] = $this->_add64($v[$c], $v[$d]);
    $v[$b] = $this->_rotr64($this->_xor64($v[$b], $v[$c]), 24);
    $v[$a] = $this->_add364($v[$a], $v[$b], $m[$this->sigma[$r][2 * $i + 1]]);
    $v[$d] = $this->_rotr64($this->_xor64($v[$d], $v[$a]), 16);
    $v[$c] = $this->_add64($v[$c], $v[$d]);
    $v[$b] = $this->_rotr64($this->_xor64($v[$b], $v[$c]), 63);
  }

  /**
   * @param $ctx
   * @param $buf
   */
  private function _compress(&$ctx, $buf): void {
    $m = [];
    $v = [];
    for($i = 16; $i--;)
      $m[$i] = $this->_load64($buf, $i * 8);
    for($i = 8; $i--;)
      $v[$i] = $ctx[0][$i];
    $v[8]  = $this->iv[0];
    $v[9]  = $this->iv[1];
    $v[10] = $this->iv[2];
    $v[11] = $this->iv[3];
    $v[12] = $this->_xor64($ctx[1][0], $this->iv[4]);
    $v[13] = $this->_xor64($ctx[1][1], $this->iv[5]);
    $v[14] = $this->_xor64($ctx[2][0], $this->iv[6]);
    $v[15] = $this->_xor64($ctx[2][1], $this->iv[7]);
    for($r = 0; $r < 12; ++$r) {
      $this->_G($v, $m, $r, 0, 0, 4, 8, 12);
      $this->_G($v, $m, $r, 1, 1, 5, 9, 13);
      $this->_G($v, $m, $r, 2, 2, 6, 10, 14);
      $this->_G($v, $m, $r, 3, 3, 7, 11, 15);
      $this->_G($v, $m, $r, 4, 0, 5, 10, 15);
      $this->_G($v, $m, $r, 5, 1, 6, 11, 12);
      $this->_G($v, $m, $r, 6, 2, 7, 8, 13);
      $this->_G($v, $m, $r, 7, 3, 4, 9, 14);
    }
    for($i = 8; $i--;)
      $ctx[0][$i] = $this->_xor64($ctx[0][$i], $this->_xor64($v[$i], $v[$i + 8]));
  }

  /**
   * @param $ctx
   * @param $inc
   */
  private function _increment_counter(&$ctx, $inc): void {
    $t         = $this->_to64($inc);
    $ctx[1][0] = $this->_add64($ctx[1][0], $t);
    if($this->_flatten64($ctx[1][0]) < $inc) {
      $ctx[1][1] = $this->_add64($ctx[1][1], $this->_to64(1));
    }
  }

  /**
   * @param $ctx
   * @param $p
   * @param $plen
   */
  private function _update(&$ctx, $p, $plen): void {
    $offset = 0;
    $left   = 0;
    $fill   = 0;
    while($plen > 0) {
      $left = $ctx[4];
      $fill = 256 - $left;
      if($plen > $fill) {
        for($i = $fill; $i--;)
          $ctx[3][$i + $left] = ord($p[$i + $offset]);
        $ctx[4] += $fill;
        $this->_increment_counter($ctx, 128);
        $this->_compress($ctx, $ctx[3]);
        for($i = 128; $i--;)
          $ctx[3][$i] = $ctx[3][$i + 128];
        $ctx[4] -= 128;
        $offset += $fill;
        $plen   -= $fill;
      }
      else {
        for($i = $plen; $i--;)
          $ctx[3][$i + $left] = ord($p[$i + $offset]);
        $ctx[4] += $plen;
        $offset += $plen;
        $plen   -= $plen;
      }
    }
  }

  /**
   * @param $ctx
   *
   * @return string
   */
  private function _finish($ctx): string {
    if($ctx[4] > 128) {
      $this->_increment_counter($ctx, 128);
      $this->_compress($ctx, $ctx[3]);
      $ctx[4] -= 128;
      for($i = $ctx[4]; $i--;)
        $ctx[3][$i] = $ctx[3][$i + 128];
    }
    $this->_increment_counter($ctx, $ctx[4]);
    $ctx[2][0] = $this->_new64(0xffffffff, 0xffffffff);
    for($i = 256 - $ctx[4]; $i--;)
      $ctx[3][$i + $ctx[4]] = 0;
    $this->_compress($ctx, $ctx[3]);
    $out = '';
    for($i = 8; $i--;) {
      $out .= pack('N', $ctx[0][$i][0]);
      $out .= pack('N', $ctx[0][$i][1]);
    }

    return strrev($out);
  }

  /**
   * @param null $key
   * @param int  $outlen
   *
   * @return array|false
   */
  private function _init($key = null, $outlen = 64): array|false {
    $_klen = isset($key) ? \count($key) : 0;
    if($_klen > 64 || $outlen > 64) {
      return false;
    }
    $_ctx = $this->_context();
    $_p   = [];
    for($i = 64; $i--;)
      $_p[$i] = 0;
    $_p[0]      = $outlen; // digest_length
    $_p[1]      = $_klen;   // key_length
    $_p[2]      = 1;       // fanout
    $_p[3]      = 1;       // depth
    $_ctx[0][0] = $this->_xor64($_ctx[0][0], $this->_load64($_p, 0));
    if($_klen > 0) {
      $_block = [];
      for($_i = 128; $_i--;)
        $_block[$_i] = 0;
      for($_i = $_klen; $_i--;)
        $_block[$_i] = $key[$_i];
      $this->_update($_ctx, $_block, 128);
    }

    return $_ctx;
  }
}