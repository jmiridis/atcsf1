<?php

/**
 * prices actions.
 *
 * @package    atc
 * @subpackage prices
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 79 2012-02-02 22:50:32Z jorgo $
 */
class reservationActions extends sfActions
{

  /**
   * Customer Access to Reservation
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeAccess(sfWebRequest $request)
  {
    $this->forward404Unless($user_id = $request->getParameter('user_id'));
    $this->forward404Unless($client = Doctrine::getTable('Client')->getByUserId($user_id));

    if($client->email_confirmed)
    {
      $this->redirect('reservation/show?uniqid='.$request->getParameter('uniqid'));
    }
    else
    {
      $client->email_confirmed = true;
      $client->save();

      $reservation = Doctrine::getTable('Reservation')->findOneByUniqid($request->getParameter('uniqid'));
      $this->dispatcher->notify(new sfEvent($reservation, 'reservation.created'));
    }

    $this->email_address  = $client->email_address;
    $this->uniqid = $request->getParameter('uniqid');
  }

  /**
   * List of 'My Reservations'
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->reservations = Doctrine_Core::getTable('Reservation')->getNotDeleted($this->getUser()->getAttribute('client_id', null, 'Client'));
  }

  public function executePaymentReceived(sfWebRequest $request)
  {
    ob_start();
    print_r($request->getPostParameters());
    file_put_contents('payment_recieved.log', ob_get_clean());
  }

  public function executeIpnTest(sfWebRequest $request)
  {
    $txn_id = '70589593893056439';
    $this->txn_id = rand();
  }

  public function executeIpn(sfWebRequest $request)
  {
  }


  /**
   * Display 1 Reservation (get by uniqid)
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->reservation = Doctrine::getTable('Reservation')->findOneByUniqid($request->getParameter('uniqid'));

    switch($this->reservation->status)
    {
      case  'open':
        $this->button = new esPaypalButton(esPaypalButton::BUTTON_TYPE_BUYNOW);
        $this->button->setParameters(array(
          'item_name' => 'Transfer Reservation '.$this->reservation->uniqid,
          'invoice'   => $this->reservation->uniqid,
          'amount'    => $this->reservation->price
        ));
        $this->button->setReturnUrlParameters(array('invoice'=>$this->reservation->uniqid));
        break;
      case 'pending':
        if(false === $this->ipn_data = $this->reservation->getIpnDataByStatus('Pending'))
        {
          $this->getLogger()->alert('Missing payment transaction (Pending) for reservation: ' . $request->getParameter('uniqid'));
        }
        break;

      case 'paid':
        if(false === $this->ipn_data = $this->reservation->getIpnDataByStatus('Completed'))
        {
          $this->getLogger()->alert('Missing payment transaction (Completed) for reservation: ' . $request->getParameter('uniqid'));
        }
        break;
    }
  }

  /**
   * Display Booking Form
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeNew(sfWebRequest $request)
  {

    $this->prices = json_encode(Doctrine::getTable('Transfer')->getActivePrices());
    $this->form   = new BookingForm(null, array('client_id'=>$this->getUser()->getAttribute('client_id', null, 'Client')));

    if($request->getParameter('destination'))
    {
      $destination  = Doctrine::getTable('Destination')->findOneBySlug($request->getParameter('destination'));
    }

    $pax = 0;
    if($request->getParameter('pax'))
    {
      $pax_limits = array_reverse(preg_split('/-/', $request->getParameter('pax')));
      $pax = $pax_limits[0];
    }

    $defaults = array(
      'destination_id' => $destination->id,
      'round_trip'     => $request->getParameter('type'),
      'no_pax'         => $pax
    );

    $this->form->setDefaults($defaults);
  }

  /**
   * Create Booking
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->prices = json_encode(Doctrine::getTable('Transfer')->getActivePrices());

    $this->form = new BookingForm(null, array('client_id'=>$this->getUser()->getAttribute('client_id', null, 'Client')));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
  /**
   * Display 1 Reservation (get by uniqid)
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeConfirmation(sfWebRequest $request)
  {
    $this->reservation = Doctrine::getTable('Reservation')->findOneByUniqid($request->getParameter('uniqid'));
  }

  /**
   * Display Reservation Modification From
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($reservation = Doctrine_Core::getTable('Reservation')->find(array($request->getParameter('id'))), sprintf('Object reservation does not exist (%s).', $request->getParameter('id')));

    $this->prices = json_encode(Doctrine::getTable('Transfer')->getActivePrices());
    $this->form = new ReservationForm($reservation);
  }

  /**
   * Modify Reservation
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($reservation = Doctrine_Core::getTable('Reservation')->find(array($request->getParameter('id'))), sprintf('Object reservation does not exist (%s).', $request->getParameter('id')));
    $this->form = new ReservationForm($reservation);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $reservation = $form->save();

      $this->redirect('@reservation_confirmation?uniqid='.$reservation->uniqid);
    }
  }
}
