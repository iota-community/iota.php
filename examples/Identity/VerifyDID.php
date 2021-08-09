<?php
  // include iota lib
  require_once("../../autoload.php");
  //
  $jsonString = '{
  "id": "did:iota:test:4ga5nnMBLcUbbpUpBQRfZY3PCNiJp6Lfu6A1wJ4oXA4y",
  "authentication": [
    {
      "id": "did:iota:test:4ga5nnMBLcUbbpUpBQRfZY3PCNiJp6Lfu6A1wJ4oXA4y#key",
      "controller": "did:iota:test:4ga5nnMBLcUbbpUpBQRfZY3PCNiJp6Lfu6A1wJ4oXA4y",
      "type": "Ed25519VerificationKey2018",
      "publicKeyBase58": "5woWnfs5C6qVyc5V72sZ2rHWZpZogruhcPittiNRohZg"
    }
  ],
  "created": "2021-07-26T20:26:20Z",
  "updated": "2021-07-26T20:26:20Z",
  "proof": {
    "type": "JcsEd25519Signature2020",
    "verificationMethod": "#key",
    "signatureValue": "54WtuHRCJq4YFUDq1HaFNMStvsLYvLBHhb9TebGHTZfKoo1FMNrc2EsEHHMfKW6hg2cbn4Gzc762qJfCi6AntEY9"
  }
}';
  // verify
  $result = \IOTA\Identity::verify($jsonString);
  // output
  var_dump($result);