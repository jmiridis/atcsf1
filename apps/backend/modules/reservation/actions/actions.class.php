<?php

/**
 * reservation actions.
 *
 * @package    atc
 * @subpackage reservation
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reservationActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->reservations = Doctrine_Core::getTable('Reservation')
      ->createQuery('a')
      ->orderBy('a.arrival_date DESC')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ReservationForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ReservationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->reservation = Doctrine_Core::getTable('Reservation')->find(array($request->getParameter('id'))), sprintf('Object reservation does not exist (%s).', $request->getParameter('id')));

    $this->transactions = $this->reservation->PaypalTransactions;

    $this->reservationUrl = Encryption::getEncryptedUrlFromUri('@reservation_show?uniqid='.$this->reservation->uniqid, $this->reservation->Client->User->id, false);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($reservation = Doctrine_Core::getTable('Reservation')->find(array($request->getParameter('id'))), sprintf('Object reservation does not exist (%s).', $request->getParameter('id')));
    $this->form = new ReservationForm($reservation);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($reservation = Doctrine_Core::getTable('Reservation')->find(array($request->getParameter('id'))), sprintf('Object reservation does not exist (%s).', $request->getParameter('id')));
    $reservation->delete();

    $this->redirect('reservation/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $reservation = $form->save();

      $this->redirect('reservation/edit?id='.$reservation->getId());
    }
  }
}
