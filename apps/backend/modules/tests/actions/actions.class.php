<?php

/**
 * tests actions.
 *
 * @package    atc
 * @subpackage tests
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class testsActions extends sfActions
{

	public function executeViewEmails(sfWebRequest $request)
	{
		sfConfig::set('sf_web_debug', false);
		$this->setLayout(false);

		$q = Doctrine_Query::create()
			->select('id')
			->from('Reservation r')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);

		$this->ids = $q->execute();

		$this->reservation_id = $request->getParameter('id', 1);
		$this->templates = array('confirm_reservation', 'request_confirmation');
	}

	public function executeViewEmail(sfWebRequest $request)
	{
		sfConfig::set('sf_web_debug', false);
		$this->setLayout(false);

		$reservation_id = $request->getParameter('id');
		$template       = $request->getParameter('template');
		$type           = $request->getParameter('type');

	  $reservation    = Doctrine::getTable('Reservation')->find($reservation_id);

//	  $url = sprintf('http://%s/access/%s',
//  	  sfConfig::get('app_domain_name', $_SERVER['SERVER_NAME']),
//  	  Encryption::encodeUrl('reservation', 'access', array(
//  	    'user_id' => $reservation->Client->User->id,
//  	    'uniqid'  => $reservation->uniqid
//  	  ))
//	  );
        $url = sprintf('http://%s/access/%s',
            sfConfig::get('app_domain_name', $_SERVER['SERVER_NAME']),
            Encryption::getEncryptedUrlFromUri(
                '@reservation_show?uniqid='.$reservation->uniqid,
                $reservation->Client->User->id
            )
        );


		$data['reservation'] = $reservation;
		$data['url']         = $url;
		$data['subject']     = 'Subject';

		$filename = $template . '_' . $type;

		$message = new esEmailMessage('Test Email');
		$message->setFrom(sfConfig::get('app_email_from'));
		$message->setTo('some@mail.com');
		$message->setAutoEmbedImages(false);
		$message->setBodyFromTemplate($this->getController(), 'reservation', $filename, $data, $type=='html'? 'email_layout' : 'none');

		return $this->renderText($message->getBody());
	}

}
