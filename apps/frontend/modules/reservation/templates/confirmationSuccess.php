<div class="page_title">&nbsp;</div>

<div class="section-box">
<div class="section-title">Reservation Confirmation</div>
<div class="section-content">
<?php if($reservation->Client->email_confirmed):?>
<p>Thank you for ordering transportation with ATC.</p>
<p>Your reservation number is: <b><?php echo $reservation->uniqid;?></b></p>
<p>A confirmation email has been sent to you containing the details of your reservation as well as further information you might need.</p>
<p>The email address, the confirmation has been sent to is:<br /><b><?php echo $reservation->Client->email_address;?></b></p>

<p style="text-align: center;"><?php //echo link_to('view reservation details', '@reservation_show?uniqid='.$reservation->uniqid);?></p>
<?php else:?>
<p>Thank you for requesting transportation with ATC.</p>
<p>In order to verify that the email address you have provided (<b><?php echo $reservation->Client->email_address;?></b>) is valid and you have access to it, a verification message has been sent.</p>
<p>Please check your inbox and click on the confirmation link contained within this email to complete your reservation.
Once you have completed this step you will receive the final confirmation for your reservation.</p>
<?php endif;?>

</div>
</div>