<div class="section-box">
<div class="section-title">Reservation Confirmation</div>
<div class="section-content">

<p>Thank you for ordering transportation with ATC.</p>

<p>Your reservation has now been confirmed</p>
<p>Your reservation number is: <b><?php echo $uniqid;?></b></p>
<p>A confirmation email has been sent to <b><?php echo $email_address;?></b> containing the details of your reservation as well as further information you might need.</p>
<br />
<div style="text-align: center;"><?php echo link_to('view reservation', '@reservation_show?uniqid='.$uniqid);?></div>
</div>
</div>
