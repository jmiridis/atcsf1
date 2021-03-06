<?php

/**
 * ClientTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ClientTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ClientTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Client');
    }

  public static function getByEmail($email_address)
  {
    $clients = Doctrine_Query::create()
      ->from('Client c')
      ->where('c.email_address = ?', $email_address)
      ->execute();

    return count($clients)? $clients[0] : null;
  }

  public static function getByUserId($user_id)
  {
    $clients = Doctrine_Query::create()
      ->from('Client c')
      ->where('c.sf_guard_user_id = ?', $user_id)
      ->execute();

    return count($clients)? $clients[0] : null;
  }
}