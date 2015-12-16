<?php
class esWidgetFormDateTimeJQuery extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('date', array());
    $this->addOption('time', array());
    $this->addOption('with_time', true);
    $this->addOption('format', '%date% %time%');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (!$this->getOption('with_time'))
    {
      return $this->getDateWidget($attributes)->render($name, $value);
    }

    return strtr($this->getOption('format'), array(
      '%date%' => $this->getDateWidget($attributes)->render($name.'[date]', $value),
      '%time%' => $this->getTimeWidget($attributes)->render($name, $value)
    ));
  }

  protected function getDateWidget($attributes = array())
  {
    return new esWidgetFormDateJQuery($this->getOptionsFor('date'), $this->getAttributesFor('date', $attributes));
  }
  /**
   * Returns the time widget.
   *
   * @param  array $attributes  An array of attributes
   *
   * @return sfWidgetForm A Widget representing the time
   */
  protected function getTimeWidget($attributes = array())
  {
    return new esWidgetFormTime($this->getOptionsFor('time'), $this->getAttributesFor('time', $attributes));
  }

  protected function getOptionsFor($type)
  {
    $options = $this->getOption($type);
    if (!is_array($options))
    {
      throw new InvalidArgumentException(sprintf('You must pass an array for the %s option.', $type));
    }

    // add id_format if it's not there already
    $options += array('id_format' => $this->getOption('id_format'));

    return $options;
  }

  /**
   * Returns an array of HTML attributes for the given type.
   *
   * @param  string $type        The type (date or time)
   * @param  array  $attributes  An array of attributes
   *
   * @return array  An array of HTML attributes
   */
  protected function getAttributesFor($type, $attributes)
  {
    $defaults = isset($this->attributes[$type]) ? $this->attributes[$type] : array();

    return isset($attributes[$type]) ? array_merge($defaults, $attributes[$type]) : $defaults;
  }

}
