<?php

/**
 * Reservation
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    atc
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Reservation.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class Reservation extends BaseReservation
{
  public function getIpnDataByStatus($status)
  {
    $ipn_data = Doctrine_Query::create()
      ->select('ipn_data')
      ->from('PaypalTransaction')
      ->where('parent_id=?', $this->id)
      ->andWhere('status=?', $status)
      ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
      ->execute();

    return (is_array($ipn_data) and (count($ipn_data) == 0))? false : unserialize($ipn_data);
  }




}