<table class="prices" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" colspan="2" style="background-color: #8AB7DD; font-weight: normal; letter-spacing: 2px; color: #000; padding: 3px 5px !important; border-top: 1px solid #666;">1 - 4 PAXS</td>
		<td>&nbsp;</td>
		<td align="center" colspan="2" style="background-color: #8AB7DD; font-weight: normal; letter-spacing: 2px; color: #000; padding: 3px 5px !important; border-top: 1px solid #666;">5 -10 PAXS</td>
	</tr>
	<tr>
		<td>Cancun Airport to ...</td>
		<td style="width:20px;">&nbsp;</td>
		<td align="center">round trip</td>
		<td align="center">one way</td>
		<td style="width:20px;">&nbsp;</td>
		<td align="center">round trip</td>
		<td align="center">one way</td>
	</tr>
	</thead>
	<tbody>
<?php foreach($destinations as $id => $destination): ?>
	<tr>
		<td><?php echo $destination['title']?></td>
		<td>&nbsp;</td>
		<td align="right"><?php echo !isset($prices[$id]['1-4']['RT'])? 'n/a' : link_to('$' . $prices[$id]['1-4']['RT'] . 'USD', '@reservation_specific1?type=RT&pax=1-4&destination='.$destination['slug'])?></td>
		<td align="right"><?php echo !isset($prices[$id]['1-4']['OW'])? 'n/a' : link_to('$' . $prices[$id]['1-4']['OW'] . 'USD', '@reservation_specific1?type=OW&pax=1-4&destination='.$destination['slug'])?></td>
		<td>&nbsp;</td>
		<td align="right"><?php echo !isset($prices[$id]['5-10']['RT'])? 'n/a' : link_to('$' . $prices[$id]['5-10']['RT'] . 'USD', '@reservation_specific1?type=RT&pax=5-10&destination='.$destination['slug'])?></td>
		<td align="right"><?php echo !isset($prices[$id]['5-10']['OW'])? 'n/a' : link_to('$' . $prices[$id]['5-10']['OW'] . 'USD', '@reservation_specific1?type=OW&pax=5-10&destination='.$destination['slug'])?></td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>

