<p>Dear <?php echo $reservation->Client;?>,</p>

<p>We have received your transportation reservation and we are glad to welcome you soon here in Cancun.</p>

<p>As this is the first time you make a reservation using this e-mail address, please click on the button below to confirm your reservation.</p>
<div style="text-align: center;">
<a href="<?php echo $url;?>"><img src="/images/btn_confirm.png" border="0" /></a>
</div>
<br />
<p>Once you have completed this step you will receive the final confirmation for your reservation and detailed information.</p>

<?php slot('title')?>
<?php echo $subject;?>
<?php end_slot()?>


<?php slot('header_image')?>
<?php echo $images['header']; ?>
<?php end_slot()?>

