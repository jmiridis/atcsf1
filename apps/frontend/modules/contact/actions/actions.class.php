<?php

/**
 * contact actions.
 *
 * @package    atc
 * @subpackage contact
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 52 2011-04-20 20:34:32Z jorgo $
 */
class contactActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new MessageForm();

    $myDefaults = array(
      'client_id'     => $this->getUser()->getAttribute('client_id',   null,'Client'),
      'email_address' => $this->getUser()->getAttribute('client_email',null,'Client')
    );

    $this->form->setDefaults(array_merge($this->form->getDefaults(), $myDefaults));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new MessageForm();

    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $message = $this->form->save();

      $data['message']       = $message->message;
      $data['email_address'] = $message->email_address;
      //--------------------------------------------------------------------------
      // build message
      //--------------------------------------------------------------------------
      $email = new esEmailMessage('Solicitud de Contacto ATC');
      $email->setAutoEmbedImages(true);
      $email->setBodyFromTemplate($this->getController(), 'contact', 'contact_request', $data, 'none');
      //--------------------------------------------------------------------------
      // send to client
      //--------------------------------------------------------------------------
      $email->setFrom($message->email_address);
      $email->setTo(sfConfig::get('app_email_contact'));
      $this->getMailer()->send($email);

      $this->redirect('contact/confirmation');
    }

    $this->setTemplate('index');
  }
  public function executeConfirmation(sfWebRequest $request)
  {
  }
}
