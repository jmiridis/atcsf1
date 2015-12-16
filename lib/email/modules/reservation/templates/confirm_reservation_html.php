<p>Dear <?php echo $reservation->Client;?>,</p>

<p>Thank you for ordering transportation with ATC.</p>

<p>This email contains important information regarding your recent transportation reservation - please save it for reference.</p>

<p>Your reservation number is: <b><?php echo $reservation->uniqid;?></b></p>

<p>You can access your reservation at any time using the following link:<br />
<div style="text-align: center;">
<a href="<?php echo $url;?>"><img src="/images/btn_access.png" border="0" /></a>
</div>
<div class="section_title"><span>Reservation Details</span></div>
<table class="reservation" cellspacing="0" cellpadding="2">
  <tr>
    <th valign="top">Customer name</th>
    <td><?php echo $reservation->Client;?></td>
  </tr>
  <tr>
    <th valign="top">Reservation #</th>
    <td><?php echo $reservation->uniqid;?></td>
  </tr>
  <tr>
    <th valign="top">Transfer</th>
    <td>Airport - <?php echo $reservation->Destination;?> (<?php echo $reservation->hotel;?>)</td>
  </tr>
  <tr>
    <th valign="top">Trip</th>
    <td><?php echo $reservation->round_trip == 'RT'? 'Round Trip' : 'One Way';?></td>
  </tr>
  <tr>
    <th valign="top"># of PAX</th>
    <td><?php echo $reservation->no_pax;?></td>
  </tr>
  <tr>
    <th valign="top">Transp. Total</th>
    <td>$<?php echo $reservation->price;?> USD</td>
  </tr>
</table>

<div class="section_title"><span>Transportation Details</span></div>
<?php if($reservation->round_trip == 'RT'):?>

<div class="sub_title">Transportation 1</div>
<?php endif;?>
<table class="reservation" cellspacing="0" cellpadding="0">
  <tr>
    <th valign="top">From</th>
    <td>Airport</td>
  </tr>
  <tr>
    <th valign="top">To</th>
    <td><?php echo $reservation->Destination;?> (<?php echo $reservation->hotel;?>)</td>
  </tr>
  <tr>
    <th valign="top">Flight #</th>
    <td><?php echo $reservation->arrival_flight_no;?></td>
  </tr>
  <tr>
    <th valign="top">Arrival</th>
    <td><?php echo $reservation->arrival_date;?></td>
  </tr>
</table>

<?php if($reservation->round_trip == 'RT'):?>
<div class="sub_title">Transportation 2</div>
<table class="reservation" cellspacing="0">
  <tr>
    <th valign="top">From</th>
    <td><?php echo $reservation->Destination;?> (<?php echo $reservation->hotel;?>)</td>
  </tr>
  <tr>
    <th valign="top">To</th>
    <td>Airport</td>
  </tr>
  <tr>
    <th valign="top">Flight #</th>
    <td><?php echo $reservation->departure_flight_no;?></td>
  </tr>
  <tr>
    <th valign="top">Departure</th>
    <td><?php echo $reservation->departure_date;?></td>
  </tr>
</table>
<?php endif;?>

