<style>
div.section_title {margin: 8px 0px 5px 0px; font-weight: bold; color: #666;}
div.section_title span {border-bottom: 1px dotted #333;}
div.sub_title {margin-left: 8px;margin-top: 5px; font-weight: bold; font-size: 8pt;}
table.details {margin-left: 8px;}
table.details th {font-style: italic; font-weight: normal; font-size: 9pt; padding: 0px 8px; line-height: 1.4em;}
table.details td {font-weight: normal; font-size: 9pt; padding: 0px;}
</style>
Dear <?php echo $reservation->firstname;?> <?php echo $reservation->lastname;?>,

<p>Thank you for ordering transportation with ATC.</p>

<p>This email contains important information regarding your recent transportation reservation - please save it for reference.</p>

<p>Your reservation number is: <b><?php echo $reservation->uniqid;?></b></p>

<p>You can access your reservation at any time using the following link:<br />
<?php echo $url;?></p>

<div class="section_title"><span>Reservation Details</span></div>
<table class="details" cellspacing="0" cellpadding="0">
  <tr>
    <th>Customer name:</td>
    <td><?php echo $reservation->firstname;?> <?php echo $reservation->lastname;?></td>
  </tr>
  <tr>
    <th>Reservation #:</td>
    <td><?php echo $reservation->uniqid;?></td>
  </tr>
  <tr>
    <th>Transfer:</td>
    <td>Airport - <?php echo $reservation->Destination;?> (<?php echo $reservation->hotel;?>)</td>
  </tr>
  <tr>
    <th>Trip:</td>
    <td><?php echo $reservation->round_trip == 'RT'? 'Round Trip' : 'One Way';?></td>
  </tr>
  <tr>
    <th># of PAX:</td>
    <td><?php echo $reservation->no_pax;?></td>
  </tr>
  <tr>
    <th>Transportation Total:</td>
    <td>$<?php echo $reservation->price;?> USD</td>
  </tr>
  <tr>
    <th>Payment method:</td>
    <td>Cash, upon arrival at Cancun Airport</td>
  </tr>
</table>

<div class="section_title"><span>Transportation Details</span></div>
<?php if($reservation->round_trip == 'RT'):?>

<div class="sub_title">Transportation 1:</div>
<?php endif;?>
<table class="details" cellspacing="0" cellpadding="0">
  <tr>
    <th>From:</td>
    <td>Airport</td>
  </tr>
  <tr>
    <th>To:</td>
    <td><?php echo $reservation->Destination;?> (<?php echo $reservation->hotel;?>)</td>
  </tr>
  <tr>
    <th>Flight #:</td>
    <td><?php echo $reservation->arrival_flight_no;?></td>
  </tr>
  <tr>
    <th>Arrival:</td>
    <td><?php echo $reservation->arrival_date;?></td>
  </tr>
</table>

<?php if($reservation->round_trip == 'RT'):?>
<div class="sub_title">Transportation 2:</div>
<table class="details" cellspacing="0">
  <tr>
    <th>From:</td>
    <td><?php echo $reservation->Destination;?> (<?php echo $reservation->hotel;?>)</td>
  </tr>
  <tr>
    <th>To:</td>
    <td>Airport</td>
  </tr>
  <tr>
    <th>Flight #:</td>
    <td><?php echo $reservation->departure_flight_no;?></td>
  </tr>
  <tr>
    <th>Departure:</td>
    <td><?php echo $reservation->departure_date;?></td>
  </tr>
</table>
<?php endif;?>

