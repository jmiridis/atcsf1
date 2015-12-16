<?php
class esValidatorDateTimeJQuery extends sfValidatorDate
{
  /**
   * prepares the value to be processed by sfValidatorDate::doClean by creating
   * flattening the array structure of the date+timewidget to a string
   *
   * Input: $value['date'], $value['hour'], $value['minute'], $value['second']
   *    where $value['date'] is in the format: yyyy-mm-dd
   *
   * Output: yyyy-mm-dd hh:mm:ss
   *
   * @param mixed $value
   * @return
   */
  protected function doClean($value)
  {
    $hour   = isset($value['hour']  )? $value['hour']   : 0;
    $minute = isset($value['minute'])? $value['minute'] : 0;
    $second = isset($value['second'])? $value['second'] : 0;

    return parent::doClean(sprintf('%s %s:%s:%s', $value['date'], $hour, $minute, $second));
  }
}
