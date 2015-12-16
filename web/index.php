<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
//---------------------------------------------------------------------------------------
// get the domain parts as an array
//---------------------------------------------------------------------------------------
list($tld, $domain, $subdomain) = array_reverse(explode('.', $_SERVER['HTTP_HOST']));
//---------------------------------------------------------------------------------------
// determine which subdomain we're looking at
//---------------------------------------------------------------------------------------
$app = (empty($subdomain) || $subdomain == 'www' ) ? 'frontend' : $subdomain;
//---------------------------------------------------------------------------------------
// determine which app to load based on subdomain
//---------------------------------------------------------------------------------------
if (!is_dir(realpath(dirname(__FILE__).'/..').'/apps/'.$app))
{
  $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
}
else
{
  $configuration = ProjectConfiguration::getApplicationConfiguration($app, 'prod', false);
}

sfContext::createInstance($configuration)->dispatch();

