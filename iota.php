<?php
  // check PHP Version
  if(0 > \version_compare(PHP_VERSION, '8.0.0')) {
    die('PHP >= 8.0.0 needed (' . PHP_VERSION . " is installed)");
    exit;
  }
  /**
   * define Line
   */
  const LF = (PHP_SAPI == 'cli' ? PHP_EOL : "<br />" . PHP_EOL);
  // register autoload
  \spl_autoload_register(/**
   * @param string $classname
   *
   * @throws Exception
   */ function (string $classname) {
    $_tmp  = \explode('\\', $classname);
    $_file = \array_pop($_tmp) . '.php';
    \array_shift($_tmp);
    $_dir = __DIR__ . '/src/' . \implode('/', $_tmp) . '/';
    //
    if(\file_exists($_dir . $_file)) {
      include_once($_dir . $_file);

      return true;
    }

    //throw new \Exception("class not found " . $classname . " . '" . ($_dir . $_file) . "'");
    return false;
  });
  /**
   * Class iota
   */
  class iota extends \iota\client\singleNode {
    /**
     * Submit a message.
     *
     * @param $index
     * @param $data
     *
     * @return \iota\schemas\response\SubmitMessage
     * @throws \Exception
     */
    public function sendMessage($index, $data): \iota\schemas\response\SubmitMessage {
      $_request                 = new \iota\schemas\request\SubmitMessage();
      $_request->payload        = new \iota\schemas\payload\Indexation();
      $_request->payload->index = $index;
      $_request->payload->data  = $data;

      return (new \iota\api\messages($this))->submit($_request);
    }

    /**
     * @param string $seed
     *
     * @return \iota\type\seed\ed25519
     */
    static public function Ed25519Seed(string $seed) {
      return new \iota\type\seed\ed25519($seed);
    }

    /**
     * @param string|array $mnemonic
     *
     * @return \iota\type\seed\ed25519
     * @throws Exception
     */
    static public function Ed25519Seed_fromMnemonic(string|array $mnemonic): \iota\type\seed\ed25519 {
      return \iota\type\seed\ed25519::fromMnemonic($mnemonic);
    }

    /**
     * @param string $publicKey
     *
     * @return \iota\type\address\ed25519
     */
    static public function Ed25519Address(string $publicKey) {
      return new \iota\type\address\ed25519($publicKey);
    }

    /**
     * @param string|null $initialPath
     *
     * @return \iota\crypto\Bip32Path
     */
    static public function Bip32Path(?string $initialPath = null): \iota\crypto\Bip32Path {
      return new \iota\crypto\Bip32Path($initialPath);
    }
  }