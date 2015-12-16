<?php slot('title');?>
Reservation Form
<?php end_slot();?>

<?php slot('meta_description');?>
Make your tranportation reservation now, filling in the following form.
<?php end_slot();?>

<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="page_title">Transfer Reservation Form</div>

<div style="margin: 15px 0px; text-align: justify;">Please fill in the following form with your trip information and personal data to request the transportation you require.
Once you have submitted the request you will receive an e-Mail which will include all the information necessary to lookup and manage your reservation.</div>

<?php echo form_tag('reservation/create');?>
<?php echo $form->renderHiddenFields(false) ?>
<div class="section-box">
<table class="styled" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
      <?php echo $form->renderGlobalErrors() ?>
	<tr>
		<td class="section-title" colspan="2">Transfer details</td>
	</tr>
	<tr>
		<th>Destination</th>
		<td><?php echo $form['destination_id']->renderError()?><?php echo $form['destination_id']->render(array('class'=>'price-sensible'))?></td>
	</tr>
	<tr>
		<th>Trip</th>
		<td><?php echo $form['round_trip']->renderError()?><?php echo $form['round_trip']->render(array('class'=>'trip-selector price-sensible'))?></td>
	</tr>
	<tr>
		<th># of PAX</th>
		<td><?php echo $form['no_pax']->renderError()?><?php echo $form['no_pax']->render(array('class'=>'price-sensible'))?></td>
	</tr>
	<tr>
		<th>Price</th>
		<td id="price">-</td>
	</tr>
	<tr>
		<td class="section-title" colspan="2">Vacation details</td>
	</tr>
	<tr>
		<th>Hotel</th>
		<td><table cellpadding="0" cellspacing="0" width="99%">
			<tr>
				<td class="mini-title">hotel or address where you will be staying in Mexico</td>
			</tr>
			<tr>
				<td colspan=""><?php echo $form['hotel']->renderError()?><?php echo $form['hotel']->render(array('style'=>'width:100%'))?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<th>Arrival</th>
		<td><table cellpadding="0" cellspacing="0">
			<tr>
				<td class="mini-title">arrival date & time</td>
				<td>&nbsp;</td>
				<td class="mini-title">flight #</td>
			</tr>
			<tr>
				<td colspan=""><?php echo $form['arrival_date']->renderError()?><?php echo $form['arrival_date']->render(array('size'=>6))?></td>
				<td style="width: 40px;">&nbsp;</td>
				<td><?php echo $form['arrival_flight_no']->renderError()?><?php echo $form['arrival_flight_no']->render(array('size'=>8))?></td>
			</tr>
		</table></td>
	</tr>
	<tr id="departure">
		<th>Departure</th>
		<td><table cellpadding="0" cellspacing="0">
			<tr>
				<td class="mini-title">departure date & time</td>
				<td>&nbsp;</td>
				<td class="mini-title">flight #</td>
			</tr>
			<tr>
				<td><?php echo $form['departure_date']->renderError()?><?php echo $form['departure_date']?></td>
				<td style="width: 40px;">&nbsp;</td>
				<td><?php echo $form['departure_flight_no']->renderError()?><?php echo $form['departure_flight_no']->render(array('size'=>8))?></td>
			</tr>
		</table></td>
	</tr>
<?php if(!$sf_user->getAttribute('client_id', null, 'Client')):?>
  <tr>
		<td class="section-title" colspan="2">Customer details</td>
	</tr>
	<tr>
		<th>Name</th>
		<td><table cellpadding="0" cellspacing="0" width="99%">
			<tr>
				<td class="mini-title">firstname</td>
				<td class="mini-title">lastname</td>
			</tr>
			<tr>
				<td width="35%"><?php echo $form['client']['firstname']->renderError()?><?php echo $form['client']['firstname']->render(array('style'=>'width:100%'))?></td>
				<td width="65%"><?php echo $form['client']['lastname']->renderError()?><?php echo $form['client']['lastname']->render(array('style'=>'width:100%'))?></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<th>e-Mail</th>
		<td><?php echo $form['client']['email_address']->renderError()?><?php echo $form['client']['email_address']->render(array('style'=>'width:99%'))?></td>
	</tr>
  <tr>
		<th>Phone number</th>
		<td><?php echo $form['client']['phone']->render(array('style'=>'width:99%'))?></td>
	</tr>
  <tr>
		<th>Country/State</th>
		<td><?php echo $form['client']['origin']->render(array('style'=>'width:99%'))?></td>
	</tr>
<?php endif;?>
	<tr>
		<td class="section-title" colspan="2">Comments</td>
	</tr>
	<tr>
		<td colspan="2">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="mini-title">Please provide any additional information you'd like us to know about in the following field.</td>
			</tr>
			<tr>
				<td align="center"><?php echo $form['comment']->render(array('style'=>'width:99%', 'rows'=>5))?></td>
			</tr>
		</table>
		</td>
	</tr>
	</tbody>
</table>
<div style="padding: 8px; text-align: center;"><input type="submit" name="submit" class="button" value="submit reservation" /></div>
</div>
</form>

<script>
var prices = <?php echo $sf_data->getRaw('prices')?>;

function get_destination_id()
{
  var destination = $('#reservation_destination_id')[0];

  return destination.options[destination.selectedIndex].value;
}


function get_trip()
{
  var round_trip = $('.trip-selector').filter(function(i,e){return e.checked});
  return (round_trip.length == 0)? '' : round_trip[0].value;
}

function get_pax()
{
  var pax = $('#reservation_no_pax')[0];
  return pax.options[pax.selectedIndex].value;
}

if(get_destination_id() && get_trip() && get_pax())
{
  price_update();
}

function price_update()
{
  var destination_id = get_destination_id()

  if(destination_id == 0)
  {
  	$('#price').html('[please select a destination]');
  	return;
  }

  var round_trip = get_trip();

  if(round_trip == '')
  {
  	$('#price').html("[please select 'one way' or 'round trip']");
  	return;
  }

  pax = get_pax();
  if(pax == '')
  {
  	$('#price').html('[please select # of pax]');
  	return;
  }
  pax = pax < 5? '1-4' : '5-10';

  var index = destination_id + '|' + pax + '|' + round_trip;

  if(prices[index] == null || prices[index] == 0 || prices[index] == '')
  {
  	$('#price').html('[this transfer is currently not available]');
  	$('input[type="submit"]').attr('disabled','disabled');
  	$('input[type="submit"]').attr('value','transfer unavailable');
  	return;
  }

  $('input[type="submit"]').removeAttr('disabled');
  $('input[type="submit"]').attr('value', 'submit reservation');
  $('#price').html('$' + prices[index] + ' USD');
}
$(function(){
	$('.trip-selector').bind('click', function(e){$('#departure').toggle(e.target.value=='RT');});
	$('#departure').toggle($('input:radio[name="reservation[round_trip]"]:checked').val() == 'RT');

	$('.price-sensible').bind('change', price_update);

 //price_update();

   jQuery.support.borderRadius = false;
   jQuery.each(['BorderRadius','MozBorderRadius','WebkitBorderRadius','OBorderRadius','KhtmlBorderRadius'], function() {
      if(document.body.style[this] !== undefined) jQuery.support.borderRadius = true;
      return (!jQuery.support.borderRadius);
   });

   if(!$.support.borderRadius) {
      $('.button').each(function() {
         $(this).wrap('<div class="buttonwrap"></div>')
         .before('<div class="corner tl"></div><div class="corner tr"></div>')
         .after('<div class="corner bl"></div><div class="corner br"></div>');
      });
   }
});
</script>