<?php

/**
 * Description of esEmailMessage
 *
 * @package    esEmailPlugin
 * @author     Georg Gell (adapted by Jorgo Miridis 2011)
 * @copyright  2010 Georg Gell
 * @version    SVN: $Id$
 */
class esEmailMessage extends Swift_Message
{

  protected $autoEmbedImages = null;

  public function setAutoEmbedImages($embed=true)
  {
    $this->autoEmbedImages = $embed? true : false;
  }

  public function setBodyFromTemplate(sfController $controller, $module, $name, array $params, $layout = null, $contentType = null, $charset = null)
  {
    //--------------------------------------------------------------------------
    // try to render template $module/$name decorating it with $layout
    //--------------------------------------------------------------------------
    $view = $this->getView($controller, $module, $name, $params, $layout);
    try
    {
      $this->setBody($this->embedImages($view->render()), $contentType, $charset);
      return $this;
    }
    catch (Exception $e)
    {
    }
    //--------------------------------------------------------------------------
    // above template could not be found so ...
    //--------------------------------------------------------------------------
    $bodies = array();
    //--------------------------------------------------------------------------
    // look for template $module/{$name}_text decorating it with $layout
    //--------------------------------------------------------------------------
    $view = $this->getView($controller, $module, $name . '_text', $params, $layout);
    $view->setDecorator(false);
    try
    {
      $bodies['text'] = $view->render();
    }
    catch (Exception $e)
    {
    }
    //--------------------------------------------------------------------------
    // look for template $module/{$name}_html decorating it with $layout
    //--------------------------------------------------------------------------
    $view = $this->getView($controller, $module, $name . '_html', $params, $layout);
    try
    {
      $bodies['html'] = $this->embedImages($view->render());
    }
    catch (Exception $e)
    {
    }

    if(count($bodies) == 0)
    {
      throw new Exception("No usable template found for email '$module'/'$name'");
    }
    if (count($bodies) == 1)
    {
      $body = reset($bodies);
      $this->setBody($body, (key($bodies) == 'html' ? 'text/html' : 'text/plain'), $charset);
    }
    else
    {
      $this->addPart($bodies['html'], 'text/html', $charset);
      $this->addPart($bodies['text'], 'text/plain', $charset);
    }
    return $this;
  }

  protected function embedImages($content)
  {
  	//--------------------------------------------------------------------------
  	// if user has not explicitly turned on/off image embedding,
		// check application config file (default false)
  	//--------------------------------------------------------------------------
  	$this->autoEmbedImages = isset($this->autoEmbedImages)? $this->autoEmbedImages : sfConfig::get('app_esEmailPlugin_autoEmbedImages', false);
  	//--------------------------------------------------------------------------
  	// if image embedding is off, return content unmodified
  	//--------------------------------------------------------------------------
  	if(!$this->autoEmbedImages)
    {
      return $content;
    }
    //--------------------------------------------------------------------------
    // find image tags with src attribute
    //--------------------------------------------------------------------------
    preg_match_all('%<img.*?src=\"(.*?)\".*?>%', $content, $matches);
    //--------------------------------------------------------------------------
    // create array of src values
    //--------------------------------------------------------------------------
    $refs = array();
    foreach($matches[1] as $source)
    {
      //------------------------------------------------------------------------
      // skip if it's a URL with scheme component
      //------------------------------------------------------------------------
      if(preg_match('%://%', $source))
      {
        continue;
      }
      //------------------------------------------------------------------------
      // embed image and keep record of the assigned CID
      //------------------------------------------------------------------------
    	$refs[$source] = $this->embed(Swift_Image::fromPath(realpath(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR . $source)));
//    	$refs[$source] = $this->embed(Swift_Image::fromPath($source));
    }
    //--------------------------------------------------------------------------
    // replace src value with CID
    //--------------------------------------------------------------------------
    return str_replace(array_keys($refs), array_values($refs), $content);
  }

  /**
  *
  * @return sfView
  */
  protected function getView(sfController $controller, $module, $name, array $params, $layout)
  {
  	//--------------------------------------------------------------------------
  	// look for a template in the specified module
  	// sf_root_dir/apps/<current application>/modules/<$module>/templates/<$name>.php
  	//--------------------------------------------------------------------------
  	$view = $controller->getView($module, $name, '');
  	//--------------------------------------------------------------------------
  	// if the template cannot be found, look in the directory specified in
  	// [app_esEmailPlugin_templateDir]/<$module>/templates or
  	// [sf_lib_dir]/email/modules/<$module>/templates
  	//--------------------------------------------------------------------------
		if (!$view->getDirectory())
    {
      $view->setDirectory(sfConfig::get('app_esEmailPlugin_templateDir', sfConfig::get('sf_lib_dir') . '/email/modules') . '/' . $module . '/templates');
    }
    $view->execute();

  	//--------------------------------------------------------------------------
  	// look for specific layout (if specified)
  	//--------------------------------------------------------------------------
		if (isset($layout))
    {
      $view->setDecoratorTemplate($layout);
			//------------------------------------------------------------------------
			// look in sf_root_dir/apps/<current application>/templates
			//------------------------------------------------------------------------
			if (!is_readable($view->getDecoratorDirectory() . '/' . $view->getDecoratorTemplate()))
      {
				//----------------------------------------------------------------------
				// if the layout cannot be found, look in the directory specified in
				// [app_esEmailPlugin_layoutDir]/email/templates or
				// [sf_lib_dir]/email/templates
				//----------------------------------------------------------------------
				$view->setDecoratorTemplate(sfConfig::get('app_esEmailPlugin_layoutDir', sfConfig::get('sf_lib_dir') . '/email/templates') . '/' . $layout);
      }
      if (!is_readable($view->getDecoratorDirectory() . '/' . $view->getDecoratorTemplate()))
      {
        throw new Exception("No usable layout found for email '$module'/'$name': layout '$layout'");
      }
    }
  	//--------------------------------------------------------------------------
  	// no specific layout, so use default layout
  	//--------------------------------------------------------------------------
  	elseif (!is_readable($view->getDecoratorDirectory() . '/' . $view->getDecoratorTemplate()))
    {
  		//------------------------------------------------------------------------
  		// no default layout found in default layout directory, so look for
			// default layout in [app_esEmailPlugin_layoutDir]/email/templates
  		//------------------------------------------------------------------------
  		$view->setDecoratorDirectory(sfConfig::get('app_esEmailPlugin_layoutDir', sfConfig::get('sf_lib_dir') . '/email/templates'));
    }

    $view->getAttributeHolder()->add($params);
    return $view;
  }
}

