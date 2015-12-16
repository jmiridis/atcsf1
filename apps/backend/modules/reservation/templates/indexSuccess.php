<script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
<style>
/* tables */
table.tablesorter {
	font-family:Verdana;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 8pt;
	width: 100%;
	text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #e6EEEE;
	border: 1px solid #FFF;
	font-size: 8pt;
	padding: 4px;
}
table.tablesorter thead tr .header {
	background-repeat: no-repeat;
	background-position: center right;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3D3D3D;
	padding: 4px;
	background-color: #FFF;
	border-bottom: 1px dotted #999;
}
table.tablesorter tbody tr.odd td {
	background-color:#F0F0F6;
}
table.tablesorter thead tr .headerSortUp {
	background-image: url(asc.gif);
}
table.tablesorter thead tr .headerSortDown {
	background-image: url(desc.gif);
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
background-color: #888888;
color: #EEEEEE
}

table.tablesorter td.paid { background-color:#A5E796; }
table.tablesorter td.open { background-color:#FFB4BC; }
table.tablesorter td.past { background-color:#DDDDDD; }
table.tablesorter td.future { background-color:#A5E796; }
</style>

<h1>Reservations List</h1>

<table id="myTable" class="tablesorter">
  <thead>
    <tr>
      <th>Reserv.</th>
      <th nowrap># Pax</th>
      <th>Destination</th>
      <th>Client</th>
      <th>Trip</th>
      <th>Arrival</th>
      <th>Departure</th>
      <th>Price</th>
      <th>Comment</th>
      <th>Status</th>
      <th>Created</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($reservations as $reservation): ?>
    <tr>
      <td align="center" class="<?php echo $reservation->getStatus() ?>"><a href="<?php echo url_for('reservation/show?id='.$reservation->getId()) ?>"><?php echo $reservation->getUniqid() ?></a></td>
      <td align="center"><?php echo $reservation->getNoPax() ?></td>
      <td><?php echo $reservation->getDestination() ?><br /><?php echo $reservation->getHotel() ?></td>
      <td><?php echo $reservation->getClient() ?></td>
      <td align="center"><?php echo $reservation->getRoundTrip() ?></td>
      <td align="center" class="<?php echo (time() < strtotime($reservation->getArrivalDate()))? 'future' : 'past';?>"><?php echo strftime('%d-%b-%Y<br />%H:%Mh', strtotime($reservation->getArrivalDate())) ?><br /><?php echo $reservation->getArrivalFlightNo() ?></td>
      <td align="center" class="<?php echo (time() < strtotime($reservation->getDepartureDate()))? 'future' : 'past';?>"><?php if($reservation->getDepartureDate()):?><?php echo strftime('%d-%b-%Y<br />%H:%Mh', strtotime($reservation->getDepartureDate())) ?><br /><?php echo $reservation->getDepartureFlightNo() ?>

      <?php endif;?></td>
      <td align="center">$<?php echo $reservation->getPrice() ?></td>
      <td><?php echo $reservation->getComment() ?></td>
      <td align="center"><?php echo $reservation->getStatus() ?></td>
      <td align="center"><?php echo strftime('%d-%b-%Y<br />%H:%Mh', strtotime($reservation->getCreatedAt())) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
$(document).ready(function()
    {
        $("#myTable").tablesorter({headers: { 1: { sorter: false}}});
    }
);
</script>
