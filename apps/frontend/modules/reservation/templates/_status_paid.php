<div class="payment-text">Thank you for your payment.</div>

<?php if($ipn_data):?>
<table class="details">
  <tr><th>Amount Paid</td><td><?php echo $ipn_data['mc_gross'];?> <?php echo $ipn_data['mc_currency'];?></td></tr>
  <tr><th>Payment Date</td><td><?php echo $ipn_data['payment_date'];?></td></tr>
  <tr><th>Transaction ID</td><td><?php echo $ipn_data['txn_id'];?></td></tr>
</table>
<?php endif;?>
