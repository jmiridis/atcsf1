<?php

/**
 * res actions.
 *
 * @package    atc
 * @subpackage res
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class resActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->reservations = Doctrine_Core::getTable('Reservation')
      ->createQuery('a')
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

    $this->redirect('res/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $reservation = $form->save();

      $this->redirect('res/edit?id='.$reservation->getId());
    }
  }
}
