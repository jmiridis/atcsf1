<?php

class myUser extends sfGuardSecurityUser
{
  static $NS = 'Client';

  public function signIn($user, $remember = false, $con = null)
  {
    parent::signIn($user, $remember, $con);

    $client = $this->getProfile();

    $this->setAttribute('client_id',   $client->id,     self::$NS);
    $this->setAttribute('client_name', (string)$client, self::$NS);
    $this->setAttribute('client_email', $client->email_address, self::$NS);
  }

  public function signOut()
  {
    $this->getAttributeHolder()->removeNamespace(self::$NS);
    parent::signOut();
  }

  public function getClient()
  {
    return $this->getProfile();
  }

}
