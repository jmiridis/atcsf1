<?php

/**
 * promotion actions.
 *
 * @package    atc
 * @subpackage promotion
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class promotionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $templateDir = sfConfig::get('app_promotion_templates_path', sfConfig::get('sf_data_dir').'/promotion');

    $templateName = $request->getParameter('key');

    $this->setLayout(false);
    $this->template_path = $templateDir . DIRECTORY_SEPARATOR . $templateName . '.html';
  }
}
