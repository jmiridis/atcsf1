<?php

/**
 * prices actions.
 *
 * @package    atc
 * @subpackage prices
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 80 2012-05-31 22:53:04Z jorgo $
 */
class pricesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$q = Doctrine_Query::create()

  		->from('Transfer t, t.Destination d')
  		->where('t.Destination_id=d.id')
  		->andWhere('t.active')
  		->orderBy('d.seq_num')
  		->setHydrationMode(Doctrine::HYDRATE_ARRAY);

  	$destinations = array();
  	$prices       = array();

  	foreach($q->execute() as $record)
  	{
  		$pax = $record['min_pax'] . '-' . $record['max_pax'];
  		$rt  = $record['round_trip'];
  		$id  = $record['destination_id'];

			$destinations[$id] = $record['Destination'];
  		$prices[$id][$pax][$rt] = $record['price'];
  		$js_prices[$id.'|'.$pax.'|'.$rt] = $record['price'];
  	}

  	$this->destinations = $destinations;
  	$this->js_prices    = $js_prices;
  	$this->prices       = $prices;
  }
}
