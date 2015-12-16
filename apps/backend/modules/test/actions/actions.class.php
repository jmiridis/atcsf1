<?php

/**
 * test actions.
 *
 * @package    atc
 * @subpackage test
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 106 2013-04-08 01:38:20Z jorgo $
 */
class testActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreateDestinationSlugs(sfWebRequest $request)
  {
    foreach(Doctrine::getTable('Destination')->findAll() as  $destination)
    {
      $destination->description = $destination->description . ' ';
      $destination->save();
    }

    return $this->renderText('');
  }
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $message = new ggEmailMessage('Testing the ggMailer');
    $message->setFrom('jorgo@miridis.com');
    $message->setTo('emilio@miridis.com');

    $data = array('url'=> 'URL', 'reservation'=>Doctrine::getTable('Reservation')->find(22));
    $message->setBodyFromTemplate($this->getController(), 'reservation', 'request_confirmation', $data, 'layout');

    $children = $message->getChildren();

    $mime = $children[0];
    $this->message = $mime->getBody();
  }

  public function executeTest()
  {
    sfConfig::set('sf_web_debug', false);

    $message = new ggEmailMessage('');
    $message->setFrom(sfConfig::get('app@email.com'));
    $message->setTo('app@email.com');

    try
    {
      $message->setBodyFromTemplate($this->getController(), 'reservation', 'confirm_reservation', array(), 'email_layout');
      $children = $message->getChildren();
      $body = $children[1]->getBody();
      $this->body = str_replace(array('<?php','?>','echo',';'), array('<span style="background-color: #F9F3BD;">','</span>','',''), $body);
    }
    catch(sfException $e)
    {
      echo $e->getMessage();
    }
  }

  public function executeMail(sfWebRequest $request)
  {
    $templates = array();

    $it = new directoryIterator($template_dir = sfConfig::get('sf_root_dir').'/lib/email/modules/reservation/templates');
    $tmp_dir = sfConfig::get('sf_web_dir').'/tmp';
    @mkdir($tmp_dir);
    while( $it->valid())
    {
      if( '.' !== substr($it->current(), 0, 1) and !$it->isDir())
      {
        $filename = $it->current();

        file_put_contents($tmp_dir.'/'.$filename, str_replace(array('<?php','?>','echo',';'), array('<span style="background-color: #F9F3BD;">','</span>','',''), file_get_contents($template_dir.'/'.$filename)));

        $templates[(string)$filename] = array(
          'type'   => substr($filename, 1, 4),
          'source' => $filename
        );
      }
      $it->next();
    }
    $this->templates = $templates;
  }


}
