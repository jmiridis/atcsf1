<style>
table.prices {margin-left: 8px;}
table.prices thead th {font-weight: bold; color: #444; padding: 5px;}
table.prices td    {font-size: 85%; font-family: Verdana; padding: 3px 5px;}
</style>

<div class="page_title">My Reservations</div>

<div class="text-box">The following table lists all your reservations, confirmed reservations as well as cancelled or closed reservations. Please click on the reservation number to view the details of each reservation.</div>
<table class="prices" id="reservations" width="100%" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th align="center">Reserv. #</th>
      <th align="center">Reserv. Date</th>
      <th align="center">Arrival Date</th>
      <th align="center"># PAX</th>
      <th align="center">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($reservations as $reservation): ?>
    <tr>
      <td align="center"><?php echo link_to($reservation->getUniqid(), '@reservation_show?uniqid='.$reservation->uniqid);?></td>
      <td align="center"><?php echo format_date($reservation->getCreatedAt(), 'd-M-y')?></td>
      <td align="center"><?php echo format_date($reservation->getArrivalDate(), 'd-M-y')?></td>
      <td align="center"><?php echo $reservation->getNoPax() ?></td>
      <td align="center"><?php echo $reservation->status ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
$(function(){ $("table#reservations tbody tr:nth-child(odd)").children('td').addClass("striped"); });
</script>