<?php

class ReservationEventManager
{

  static public function handleEvent(sfEvent $event)
  {
    $reservation =  $event->getSubject();

    switch($event->getName())
    {
      case 'reservation.pre_update':
        break;

      case 'reservation.post_update':
        break;


      case 'reservation.created':

        $url = Encryption::getEncryptedUrlFromUri('@reservation_show?uniqid='.$reservation->uniqid, $reservation->Client->User->id);

        if($reservation->Client->email_confirmed)
        {
          $subject  = 'ATC: Reservation Confirmation #'.$reservation->uniqid;
          $template = 'confirm_reservation';
        }
        else
        {
          $subject  = 'ATC: please confirm your reservation';
          $template = 'request_confirmation';
        }


        $data = array(
          'email_address' => $reservation->Client->email_address,
          'subject'       => $subject,
          'url'           => $url,
          'reservation'   => $reservation
        );

        self::sendNotification($template, $data);
        break;
    }
  }

  /**
   * handles the sending of notification related to reservation events
   *
   * @param string $template name of the template to be used for the email
   * @param array $data parameters required to build the messfga
   * @return
   */
  static protected function sendNotification($template, $data)
  {
    $email_addr = $data['email_address'];
    unset($data['email_address']);

    $mailer     = sfContext::getInstance()->getMailer();
    $controller = sfContext::getInstance()->getController();
    //--------------------------------------------------------------------------
    // build message
    //--------------------------------------------------------------------------
    $message = new esEmailMessage($data['subject']);
    $message->setAutoEmbedImages(true);
    $message->setBodyFromTemplate($controller, 'reservation', $template, $data, 'email_layout');
    //--------------------------------------------------------------------------
    // send to client
    //--------------------------------------------------------------------------
    $message->setFrom(sfConfig::get('app_email_from'));
    $message->setTo($email_addr);
    $mailer->send($message);
    //--------------------------------------------------------------------------
    // send to backend
    //--------------------------------------------------------------------------
    $message->setFrom(sfConfig::get('app_email_from'));
    $message->setTo(sfConfig::get('app_email_bcc'));
    $mailer->send($message);
  }
}
