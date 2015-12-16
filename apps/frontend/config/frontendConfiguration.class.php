<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    $this->dispatcher->connect('reservation.pre_update',  array('ReservationEventManager', 'handleEvent'));
    $this->dispatcher->connect('reservation.post_update', array('ReservationEventManager', 'handleEvent'));
    $this->dispatcher->connect('reservation.created',     array('ReservationEventManager', 'handleEvent'));

    $this->dispatcher->connect('paypal.ipn_error',   array('PaypalEventManager', 'handleEvent'));
    $this->dispatcher->connect('paypal.ipn_success', array('PaypalEventManager', 'handleEvent'));
  }
}
