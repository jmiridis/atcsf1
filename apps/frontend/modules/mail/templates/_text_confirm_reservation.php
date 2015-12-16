Dear <?php echo $reservation->firstname;?> <?php echo $reservation->lastname;?>,

Thank you for ordering transportation with ATC.

This email contains important information regarding your recent transportation reservation – please save it for reference.

Your reservation number is: <?php echo $reservation->uniqid;?>

You can access your reservation at any time using the following link:<br />
<?php echo $url;?>

Reservation Details
====================
Customer name: <?php echo $reservation->firstname;?> <?php echo $reservation->lastname;?>
Reservation #: <?php echo $reservation->uniqid;?>
Transportation Total: $<?php echo $reservation->price;?> USD
Transfer: Airport - <?php echo $reservation->Destination;?> (<?php echo $reservation->Destination;?>), <?php echo $reservation->round_trip == 'RT'? 'Round Trip' : 'One Way';?>
# of PAX: <?php echo $reservation->no_pax;?>

Transportation Details
----------------------
<?php if($reservation->round_trip == 'RT'):?>

Transportation 1:
<?php endif;?>
  From Airport to <?php echo $reservation->Destination;?> (<?php echo $reservation->Destination;?>)
  Arrival: 3-feb-2011 4:31pm, flight #: AA3451

<?php if($reservation->round_trip == 'RT'):?>
Transportation 2:
  From: <?php echo $reservation->Destination;?>, <?php echo $reservation->Destination;?> -> Airport
  Departure: 10-feb-2011 9:05pm, flight #: AA3453
<?php endif;?>

