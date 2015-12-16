<?php


/**
 *
 *
 **/
class esPaypalEncryptor
{
  /**
   * esPaypalButton::setCertificate()
   *
   * @param mixed $certificateFilename - The path to the client certificate
   * @param mixed $privateKeyFilename - The path to the private key corresponding to the certificate
   * @return boolean TRUE if the private key matches the certificate.
   */
  public function setCertificate($certificateFilename, $privateKeyFilename)
  {
    if (is_readable($certificateFilename) && is_readable($privateKeyFilename))
    {
      $certificate = openssl_x509_read(file_get_contents($certificateFilename));
      $privateKey  = openssl_get_privatekey(file_get_contents($privateKeyFilename));

      if (($certificate !== FALSE) && ($privateKey !== FALSE) && openssl_x509_check_private_key($certificate, $privateKey))
      {
        $this->certificate = $certificate;
        $this->certificateFile = $certificateFilename;

        $this->privateKey = $privateKey;
        $this->privateKeyFile = $privateKeyFilename;

        return true;
      }
    }

    return false;
  }

  /**
   * esPaypalButton::setCertificateID()
   *
   * @param mixed $id - The certificate ID assigned when the certificate was uploaded to PayPal
   * @return void
   */
  public function setCertificateID($id)
  {
    $this->certificateID = $id;

  }

  /**
   * Sets the PayPal certificate
   *
   * @param mixed $fileName - The path to the PayPal certificate.
   * @return bollean TRUE if the certificate is read successfully, FALSE otherwise.
   */
  public function setPayPalCertificate($fileName)
  {
    if (is_readable($fileName))
    {
      $certificate = openssl_x509_read(file_get_contents($fileName));

      if ($certificate !== FALSE)
      {
        $this->paypalCertificate     = $certificate;
        $this->paypalCertificateFile = $fileName;

        return TRUE;
      }
    }

    return FALSE;
  }

  public function encryptData($data)
  {
    if (($this->certificateID == '') || !isset($this->certificate) || !isset($this->paypalCertificate))
    {
      return FALSE;
    }

    sfContext::getInstance()->getLogger()->warning('esPaypalButton: data ...');

    $parameters = array();

    $data['cert_id'] = $this->certificateID;
    foreach ($data as $key => $value)
    {
      $parameters[] = "$key=$value";
      sfContext::getInstance()->getLogger()->warning("$key=$value");
    }

    $clearText = join("\n", $parameters);
    sfContext::getInstance()->getLogger()->warning($clearText);

    $clearFile     = tempnam('/tmp', 'clear');
    $signedFile    = tempnam('/tmp', 'signed');
    $encryptedFile = tempnam('/tmp', 'encrypted');

    $out = fopen($clearFile, 'wb');
    fwrite($out, $clearText);
    fclose($out);

    if (!openssl_pkcs7_sign($clearFile, $signedFile, $this->certificate, $this->privateKey, array(), PKCS7_BINARY)) {
      return FALSE;
    }

    $signedData = explode("\n\n", file_get_contents($signedFile));

    $out = fopen($signedFile, 'wb');
    fwrite($out, base64_decode($signedData[1]));
    fclose($out);

    if (!openssl_pkcs7_encrypt($signedFile, $encryptedFile, $this->paypalCertificate, array(), PKCS7_BINARY)) {
      return FALSE;
    }

    $encryptedData = explode("\n\n", file_get_contents($encryptedFile));

    $encryptedText = $encryptedData[1];

    @unlink($clearFile);
    @unlink($signedFile);
    @unlink($encryptedFile);

    return sprintf('-----BEGIN PKCS7-----%s-----END PKCS7-----', trim(str_replace("\n", "", $encryptedText)));
  }
}