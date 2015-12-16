<?php
function pp_button(esPaypalButton $button)
{
  $html = array();
  foreach ($button as $name => $value)
  {
    $html[] = tag('input', array('type'=>'hidden', 'name'=>$name, 'value'=>$value));
  }

  return form_tag($button->getUrl(), array('method'=>'post')) .
         join("\n", $html) .
         tag('input', array('type'=>'image', 'src'=>$button->getImage(), 'alt'=>$button->getAltText())) .
         '</form>';
}
