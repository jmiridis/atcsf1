<?php

class esWidgetFormTime extends sfWidgetFormTime
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('am_pm', true);
    $this->addOption('minute_prefix', null);

    parent::configure($options, $attributes);

    if($options['am_pm'])
    {
      $hours = array();
      for ($i = 0; $i <= 23; $i++)
      {
        $hours[$i+1] = sprintf('%02d %s', $i%12+1, $i<12? 'am' : 'pm');
      }
      $this->setOption('hours', $hours);
    }

    if('' != (string)$options['minute_prefix'])
    {
      $minutes = $this->generateTwoCharsRange(0,59);
      foreach($minutes as $idx => $value)
      {
        $minutes[$idx] = $options['minute_prefix'] . $value;
      }
      $this->setOption('minutes', $minutes);
    }
  }
}
