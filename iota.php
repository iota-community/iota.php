<?php
  // check PHP Version
  if(0 > version_compare(PHP_VERSION, '8.0.0')) {
    die('PHP >= 8.0.0 needed (' . PHP_VERSION . " is installed)");
    exit;
  }
  /**
   * define Line
   */
  const LF = (PHP_SAPI == 'cli' ? PHP_EOL : "<br />" . PHP_EOL);
  // register autoload
  spl_autoload_register(/**
   * @param string $classname
   *
   * @return bool
   */ function (string $classname) {
    $_tmp  = explode('\\', $classname);
    $_file = array_pop($_tmp) . '.php';
    array_shift($_tmp);
    $_dir = __DIR__ . '/src/' . implode('/', $_tmp) . '/';
    //
    if(file_exists($_dir . $_file)) {
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
     * Submit a message
     *
     * @param      $index
     * @param      $data
     * @param bool $_convertToHex
     *
     * @return \iota\schemas\response\SubmitMessage
     * @throws Exception
     */
    public function sendMessage($index, $data, $_convertToHex = true): \iota\schemas\response\SubmitMessage {
      $_sMsg          = new \iota\schemas\request\SubmitMessage();
      $_sMsg->payload = self::createIndexation($index, $data, $_convertToHex);

      return $this->messageSubmit($_sMsg);
    }

    /**
     * @param      $index
     * @param bool $_convertToHex
     *
     * @return \iota\schemas\response\MessagesFind
     */
    public function findMessage($index, $_convertToHex = true) {
      $index = \iota\converter::bin2hex($index);

      return $this->messagesFind($index);
    }

    /**
     * @param string $messageId
     *
     * @return \iota\schemas\response\Message
     * @throws Exception
     */
    public function getMessage(string $messageId,bool $_covertHexToString = true): \iota\schemas\response\Message {
      $_result = $this->message($messageId);
      if($_covertHexToString && $_result) {
        $_result->payload->index = \iota\converter::hex2bin($_result->payload->index);
        $_result->payload->data  = \iota\converter::hex2bin($_result->payload->data);
      }

      return $_result;
    }

    /**
     * @param string $messageId
     * @param bool   $_covertHexToString
     *
     * @return \iota\schemas\payload|false
     * @throws Exception
     */
    public function getMessagePayload(string $messageId,bool $_covertHexToString = true): \iota\schemas\payload|false {
      if(($_result = $this->getMessage($messageId, $_covertHexToString)) && $_result->payload) {
        return $_result->payload;
      }

      //todo@st: throw exception?
      return false;
    }

    /**
     * @param \iota\type\seed\ed25519                $walledSeed
     * @param int                                    $_accountIndex
     * @param string                                 $addressBech32
     * @param                                        $amount
     * @param false|\iota\schemas\payload\Indexation $_indexation
     *
     * @return \iota\schemas\response\SubmitMessage
     * @throws SodiumException
     * @throws \iota\exception\converter
     */
    public function send(\iota\type\seed\ed25519 $walledSeed, int $_accountIndex, string $addressBech32, $amount, false|\iota\schemas\payload\Indexation $_indexation = false): \iota\schemas\response\SubmitMessage {
      // creating Transaction SubmitMessage
      $_sMsg        = new \iota\schemas\request\SubmitMessage();
      $_transaction = $_sMsg->payload = new \iota\schemas\payload\Transaction();
      $_essence     = $_transaction->essence = new \iota\schemas\essence\Transaction();
      // if indexation
      if($_indexation) {
        $_essence->payload = $_indexation;
      }
      // generate address BASE_PATH m/44'/4218', accountIndex, isInternal, addressIndex
      $addressPath = iota::Bip32Path("m/44'/4218'/{$_accountIndex}}'/0'/0'");
      $addressSeed = $walledSeed->generateSeedFromPath($addressPath);
      $address     = iota::Ed25519Address(($addressSeed->keyPair())['publicKey']);
      $_outputs    = $this->addressesed25519Output($address->toAddress());
      // parse outputs
      $_total = 0;
      foreach(($_outputs)->outputIds as $_id) {
        $_output = $this->output($_id);
        if(!$_output->isSpent && $amount > $_total) {
          $_essence->inputs[] = new \iota\schemas\input([
            'type'                   => 0,
            'transactionId'          => $_output->transactionId,
            'transactionOutputIndex' => $_output->outputIndex,
          ]);
          $_total             += $_output->output['amount'];
        }
      }
      if($_total == 0 || $_total < $amount) {
        throw new Exception("There are not enough funds in the inputs for the required balance! amount: {$amount}, balance: {$_total}");
      }
      // transfer to new address
      $_essence->outputs[] = new \iota\schemas\output([
        'type'    => 0,
        'address' => [
          'type'    => 0,
          'address' => self::bech32toEd25519($addressBech32),
        ],
        'amount'  => $amount,
      ]);
      // sending remainder back, if amount not zero
      if($_total - $amount > 0) {
        $_essence->outputs[] = new \iota\schemas\output([
          'type'    => 0,
          'address' => [
            'type'    => 0,
            'address' => $address->toAddress(),
          ],
          'amount'  => $_total - $amount,
        ]);
      }
      // sort inputs / outputs
      sort($_essence->inputs);
      sort($_essence->outputs);
      // unlockBlocks
      $_list = [];
      foreach($_essence->inputs as $_k => $input) {
        $_publicKey = ($addressSeed->keyPair())['publicKey'];
        if(isset($_list[$_publicKey])) {
          $_transaction->unlockBlocks[] = new \iota\schemas\unlockBlocks\Reference([
            'type'      => 1,
            'reference' => $_list[$_publicKey],
          ]);
        }
        else {
          $_transaction->unlockBlocks[] = new \iota\schemas\unlockBlocks\Signature([
            'type'      => 0,
            'signature' => new \iota\schemas\ed25519Signature([
              'type'      => 0,
              'publicKey' => $_publicKey,
              'signature' => \iota\crypto\Ed25519::sign(($addressSeed->keyPair())['privateKey'], $_essence->__toHash()),
            ]),
          ]);
          $_list[$_publicKey]           = count($_transaction->unlockBlocks) - 1;
        }
      }

      return $this->messageSubmit($_sMsg);
    }

    /**
     * @param      $index
     * @param      $data
     * @param bool $_convertToHex
     *
     * @return \iota\schemas\payload\Indexation
     */
    static public function createIndexation($index, $data, $_convertToHex = true) {
      $_indexation        = new \iota\schemas\payload\Indexation();
      $_indexation->index = $_convertToHex ? \iota\converter::bin2hex($index) : $index;
      $_indexation->data  = $_convertToHex ? \iota\converter::bin2hex($data) : $data;

      return $_indexation;
    }

    /**
     * @param string $addressBech32
     *
     * @return string
     * @throws \iota\exception\converter
     */
    static public function bech32toEd25519(string $addressBech32): string {
      $_data = \iota\crypto\Bech32::decode($addressBech32)[1];

      return substr(\iota\converter::byteArray2Hex(\iota\converter::bits($_data, count($_data), 5, 8, false)), 2);
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

    /**
     * @param string $API_ENDPOINT
     * @param array  $_options
     *
     * @return \iota\client\api
     */
    static public function api(string $API_ENDPOINT, array $_options = []) {
      return new \iota\client\api($API_ENDPOINT, $_options);
    }
  }