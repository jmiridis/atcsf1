<?php

/**
 * myreservations actions.
 *
 * @package    atc
 * @subpackage myreservations
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class myreservationsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->reservations = Doctrine_Core::getTable('Reservation')
      ->createQuery('a')
      ->orderBy('created_at')
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

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($reservation = Doctrine_Core::getTable('Reservation')->find(array($request->getParameter('id'))), sprintf('Object reservation does not exist (%s).', $request->getParameter('id')));
    $this->form = new ReservationForm($reservation);
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

    $this->redirect('myreservations/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $reservation = $form->save();

      $this->redirect('myreservations/edit?id='.$reservation->getId());
    }
  }
}
