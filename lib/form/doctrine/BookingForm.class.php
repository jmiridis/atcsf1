<?php

/**
 * Client form.
 *
 * @package    atc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BookingForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class BookingForm extends ReservationForm
{
  public function configure()
  {
    parent::configure();

    //--------------------------------------------------------------------------
    // when creating a new reservation, the client id comes either from the
    // session (user is logged in) or the client form must be embedded
    //--------------------------------------------------------------------------
    if($this->isNew())
    {
      if($client_id = $this->getOption('client_id'))
      {
        $this->setDefault('client_id', $client_id);
      }
      else
      {
        unset($this['client_id']);
        $this->embedForm('client', new ClientForm());
      }
    }
  }

  protected function doSave($con=null)
  {
    //--------------------------------------------------------------------------
    // populate objects related to ReservationForm & ClientForm with posted data
    //--------------------------------------------------------------------------
    $this->updateObject();
    //--------------------------------------------------------------------------
    // get populated reservation object
    //--------------------------------------------------------------------------
    $reservation = $this->getObject();
    //--------------------------------------------------------------------------
    // if it's a new reservation we have to make sure to detect existing clients
    // and retrieve their client id if it's the case
    //--------------------------------------------------------------------------
    if($this->isNew())
    {
      if(isset($this->embeddedForms['client']))
      {
        //----------------------------------------------------------------------
        // check if the client exists, if not, save and get new client id
        //----------------------------------------------------------------------
        $values = $this->getValue('client');
        if(null == $client = Doctrine::getTable('Client')->getByEmail($values['email_address']))
        {
          //--------------------------------------------------------------------
          // create login user
          //--------------------------------------------------------------------
          $sfGuardUser = new sfGuardUser();
          $sfGuardUser->first_name = $values['firstname'];
          $sfGuardUser->last_name  = $values['lastname'];
          $sfGuardUser->username   = $values['email_address'];
          $sfGuardUser->email_address = $values['email_address'];
          $sfGuardUser->setPassword('admin');
          $sfGuardUser->setIsActive(true);
          $sfGuardUser->save();
          //--------------------------------------------------------------------
          // save object related to ClientForm
          //--------------------------------------------------------------------
          $client = $this->embeddedForms['client']->object;
          $client->sf_guard_user_id = $sfGuardUser->id;
          $client->save();
        }

        $reservation->client_id = $client->id;
      }
      else
      {
        $reservation->client_id = $this->getOption('client_id');
      }
      //------------------------------------------------------------------------
      // add the uniqe confirmation id and set initial status
      //------------------------------------------------------------------------
      $reservation->uniqid = 'pending';
      $reservation->status = 'open';
    }
    else
    {
      // triggered only when updating reservations
      self::$dispatcher->notify(new sfEvent($reservation, 'reservation.pre_update'));
    }
    //--------------------------------------------------------------------------
    // the price depends on destination, round_trip and no_pax
    //--------------------------------------------------------------------------
    $reservation->price = Doctrine::getTable('Transfer')->getPrice($reservation->destination_id, $reservation->round_trip, $reservation->no_pax);
    $reservation->save();
    $reservation->uniqid = strtoupper(base_convert((integer)sprintf('1%07d', $reservation->id), 10, 36));
    $reservation->save();

    self::$dispatcher->notify(new sfEvent($reservation, $this->isNew()? 'reservation.created' : 'reservation.post_update'));
  }
}
