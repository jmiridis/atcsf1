<?php

/**
 * BasesfGuardFormSignin
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardFormSignin.class.php 32864 2011-08-02 09:16:45Z gimler $
 */
class BasesfGuardFormSignin extends BaseForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(array('type' => 'password')),
      'remember' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'username' => new sfValidatorString(),
      'password' => new sfValidatorString(),
      'remember' => new sfValidatorBoolean(),
    ));

    if (sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true))
    {
      $this->widgetSchema['username']->setLabel('Username or E-Mail');
    }

    $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());

    $this->widgetSchema->setNameFormat('signin[%s]');

    parent::setup();
  }
}