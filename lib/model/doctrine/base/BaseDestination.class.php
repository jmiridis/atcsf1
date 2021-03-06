<?php

/**
 * BaseDestination
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $title
 * @property text $description
 * @property integer $seq_num
 * @property boolean $active
 * @property Doctrine_Collection $Transfers
 * @property Doctrine_Collection $Reservations
 * 
 * @method string              get()             Returns the current record's "title" value
 * @method text                get()             Returns the current record's "description" value
 * @method integer             get()             Returns the current record's "seq_num" value
 * @method boolean             get()             Returns the current record's "active" value
 * @method Doctrine_Collection get()             Returns the current record's "Transfers" collection
 * @method Doctrine_Collection get()             Returns the current record's "Reservations" collection
 * @method Destination         set()             Sets the current record's "title" value
 * @method Destination         set()             Sets the current record's "description" value
 * @method Destination         set()             Sets the current record's "seq_num" value
 * @method Destination         set()             Sets the current record's "active" value
 * @method Destination         set()             Sets the current record's "Transfers" collection
 * @method Destination         set()             Sets the current record's "Reservations" collection
 * 
 * @package    atc
 * @subpackage model
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDestination extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('destination');
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('seq_num', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Transfer as Transfers', array(
             'local' => 'id',
             'foreign' => 'destination_id'));

        $this->hasMany('Reservation as Reservations', array(
             'local' => 'id',
             'foreign' => 'destination_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'title',
             ),
             'canUpdate' => true,
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}