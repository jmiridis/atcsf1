<?php

/**
 * BaseClient
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $sf_guard_user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $origin
 * @property string $phone
 * @property string $email_address
 * @property boolean $email_confirmed
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Reservations
 * @property Doctrine_Collection $Messages
 * 
 * @method integer             get()                 Returns the current record's "sf_guard_user_id" value
 * @method string              get()                 Returns the current record's "firstname" value
 * @method string              get()                 Returns the current record's "lastname" value
 * @method string              get()                 Returns the current record's "origin" value
 * @method string              get()                 Returns the current record's "phone" value
 * @method string              get()                 Returns the current record's "email_address" value
 * @method boolean             get()                 Returns the current record's "email_confirmed" value
 * @method sfGuardUser         get()                 Returns the current record's "User" value
 * @method Doctrine_Collection get()                 Returns the current record's "Reservations" collection
 * @method Doctrine_Collection get()                 Returns the current record's "Messages" collection
 * @method Client              set()                 Sets the current record's "sf_guard_user_id" value
 * @method Client              set()                 Sets the current record's "firstname" value
 * @method Client              set()                 Sets the current record's "lastname" value
 * @method Client              set()                 Sets the current record's "origin" value
 * @method Client              set()                 Sets the current record's "phone" value
 * @method Client              set()                 Sets the current record's "email_address" value
 * @method Client              set()                 Sets the current record's "email_confirmed" value
 * @method Client              set()                 Sets the current record's "User" value
 * @method Client              set()                 Sets the current record's "Reservations" collection
 * @method Client              set()                 Sets the current record's "Messages" collection
 * 
 * @package    atc
 * @subpackage model
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseClient extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('client');
        $this->hasColumn('sf_guard_user_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('firstname', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('lastname', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('origin', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('phone', 'string', 50, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 50,
             ));
        $this->hasColumn('email_address', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('email_confirmed', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'sf_guard_user_id',
             'foreign' => 'id'));

        $this->hasMany('Reservation as Reservations', array(
             'local' => 'id',
             'foreign' => 'client_id'));

        $this->hasMany('Message as Messages', array(
             'local' => 'id',
             'foreign' => 'client_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}