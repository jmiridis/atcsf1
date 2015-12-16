<?php

class PaypalEventManager
{

  static public function handleEvent(sfEvent $event)
  {

    switch($event->getName())
    {
      case 'paypal.ipn_success':
        $transaction = $event->getSubject();

        $message = sprintf('IPN Success | Reservation: %s', $transaction->parent_id);
        self::notifyPaypalEvent($message, $event['ipn_data']);
        break;

      case 'paypal.ipn_error':
        $message = sprintf('IPN Error |  %s', $event->getSubject());
        self::notifyPaypalEvent($message, $event['ipn_data']);
        break;
    }
  }

  static protected function notifyPaypalEvent($message, $data)
  {
    $fp = fopen(sfConfig::get('sf_log_dir').'/paypal.log', 'a');
    fputs($fp, date("H:i:s d/M/Y ******************************\n"));
    fputs($fp, "$message\n");
    fclose($fp);

    //$mailer     = sfContext::getInstance()->getMailer();
    //$controller = sfContext::getInstance()->getController();
    //--------------------------------------------------------------------------
    // build message
    //--------------------------------------------------------------------------
    //$message = new esEmailMessage($message);
    //$message->setAutoEmbedImages(true);
    //$message->setBodyFromTemplate($controller, 'reservation', $template, $data, 'email_layout');
    //--------------------------------------------------------------------------
    // send to client
    //--------------------------------------------------------------------------
    //$message->setFrom(sfConfig::get('app_email_from'));
    //$message->setTo($email_addr);
    //$mailer->send($message);


  }
}
