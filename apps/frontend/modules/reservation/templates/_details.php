<style>
div.sub_title {margin-left: 8px;margin-top: 5px; padding: 2px 5px; font-weight: bold; background-color: #DDD;}
table.details {margin-left: 8px;}
table.details th {text-align: right; font-style: italic; font-weight: normal; font-size: ; padding: 0px 8px; line-height: 1.4em;}
table.details td {font-weight: normal; font-size: ; padding: 0px;}
ul.info { margin: 0; }
ul.info li {  margin: 4px 0px; line-height: 1.15em;}
</style>

<div class="section-box">
<div class="section-title">Reservation Details</div>
<div class="section-content">
<table class="details" cellspacing="0" cellpadding="0">
  <tr>
    <th>Customer name:</td>
    <td><?php echo $reservation->Client;?></td>
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
    <th nowrap>Transportation Total:</td>
    <td>$<?php echo $reservation->price;?> USD</td>
  </tr>
</table>
</div>
</div>


<div class="section-box">
<div class="section-title">Transportation Details</div>
<div class="section-content">
<?php if($reservation->round_trip == 'RT'):?>

<div class="option">Transportation A</div>
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
<div class="separator">&nbsp;</div>
<div class="option">Transportation B</div>
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
</div>
</div>

<div class="section-box">
<div class="section-title">General Information / Recommendations</div>
<div class="section-content">
<ul class="info">
  <li>Amounts are in U.S. Dollars. </li>
  <li>We accept U.S. and Canadian Dollars (rate: 1 CAD = 1 USD). If you'd rather pay in Mexican Pesos, please check the current rate with your driver.</li>
  <li>Please print this confirmation and have it with you upon arrival in Cancun.</li>
  <li>To not be fooled by others at the airport, if lost: Call +52 (998) 214-5918 or +52 (998) 201-1720. Our staff is at the airport, they just might be assisting other passengers.</li>
</ul>

<?php if($reservation->round_trip == 'RT'):?>
<?php endif;?>
</div>
</div>