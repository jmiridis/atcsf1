<h3>My Reservations</h3>

<table width="100%">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th align="center">Res. #</th>
      <th align="center">Reservation date</th>
      <th align="center">Arrival date</th>
      <th align="center"># PAX</th>
      <th align="center">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($reservations as $reservation): ?>
    <tr>
      <td align="center"><?php echo link_to(image_tag('/images/view-plus.png', 'width=20,height=16,border=0'), '@reservation_show?uniqid='.$reservation->uniqid);?></td>
      <td align="center"><?php echo $reservation->getUniqid() ?></td>
      <td align="center"><?php echo format_date($reservation->getCreatedAt(), 'd-M-y')?></td>
      <td align="center"><?php echo format_date($reservation->getArrivalDate(), 'd-M-y')?></td>
      <td align="center"><?php echo $reservation->getNoPax() ?></td>
      <td align="center">closed</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php

/*

'G' => 'Era',
'y' => 'year',
'M' => 'mon',
'd' => 'mday',
'h' => 'Hour12',
'H' => 'hours',
'm' => 'minutes',
's' => 'seconds',
'E' => 'wday',
'D' => 'yday',
'F' => 'DayInMonth',
'w' => 'WeekInYear',
'W' => 'WeekInMonth',
'a' => 'AMPM',
'k' => 'HourInDay',
'K' => 'HourInAMPM',
'z' => 'TimeZone'
   */?>