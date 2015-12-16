<p>Your payment transaction has been completed but the transfer of the funds is still pending.</p>
<p>Once Paypal has transferred the funds to our account, this message will be updated automatically to reflect the new status of your payment.</p>
<?php if($ipn_data):?>
<table class="details">
  <tr><th>Amount Pending</td><td><?php echo $ipn_data['mc_gross'];?> <?php echo $ipn_data['mc_currency'];?></td></tr>
  <tr><th>Transaction Date</td><td><?php echo $ipn_data['payment_date'];?></td></tr>
  <tr><th>Transaction ID</td><td><?php echo $ipn_data['txn_id'];?></td></tr>
</table>
<?php endif;?>
