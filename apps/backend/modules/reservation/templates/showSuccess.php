<script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>

<style>
th.column-title {background-color: rgb(138, 183, 221); font-weight: normal; letter-spacing: 2px; color: rgb(0, 0, 0); padding: 3px 5px ! important; border-top: 1px solid rgb(102, 102, 102); }
.bg { background-color: #CCC; padding: 2px 4px;}
</style>
<h1>Reservation <?php echo $reservation->uniqid;?></h1>
<div style="text-align: right; padding: 0px 8px 8px 8px;"><a href="<?php echo url_for('reservation/index') ?>">Back to list</a></div>

<table width="100%" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
    <td width="50%" style="padding: 0px 8px 0px 0px ;" valign="top">
      <table class="styled" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th class="column-title" colspan="2">Reservation</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Destination</th>
            <td class="data"><?php echo $reservation->Destination ?></td>
          </tr>
          <tr>
            <th>Hotel</th>
            <td class="data"><?php echo $reservation->hotel ?></td>
          </tr>
          <tr>
            <th>Trip</th>
            <td class="data"><?php echo $reservation->round_trip ?></td>
          </tr>
          <tr>
            <th># of Pax</th>
            <td class="data"><?php echo $reservation->no_pax ?></td>
          </tr>
          <tr>
            <th>Arrival</th>
            <td class="data"><?php echo strftime('%a, %d-%b-%Y %H:%Mh', strtotime($reservation->arrival_date)) ?>&nbsp;|&nbsp;Flight&nbsp;<?php echo $reservation->arrival_flight_no ?></td>
          </tr>
          <tr>
            <th>Departure</th>
            <td class="data"><?php if($reservation->departure_date):?><?php echo strftime('%a, %d-%b-%Y %H:%Mh', strtotime($reservation->departure_date)) ?>&nbsp;|&nbsp;Flight&nbsp;<?php echo $reservation->departure_flight_no ?><?php endif;?></td>
          </tr>
          <tr>
            <th>Comment</th>
            <td class="data"><?php echo $reservation->comment ?></td>
          </tr>
        </tbody>
      </table>
    </td>
    <td width="50%" style="padding: 0px 0px 0px 8px;" valign="top">
  <table class="styled" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th class="column-title" colspan="2">Client</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Name</th>
            <td class="data"><?php echo $reservation->Client->firstname . ' ' . $reservation->Client->lastname?></td>
          </tr>
          <tr>
            <th>Origin</th>
            <td class="data"><?php echo $reservation->Client->origin ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td class="data"><?php echo $reservation->Client->email_address ?></td>
          </tr>
          <tr>
            <th>Phone</th>
            <td class="data"><?php echo $reservation->Client->phone ?></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  </tbody>
</table>
<br />
      <table class="styled" cellpadding="0" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th class="column-title" colspan="4">Paypal Transactions</th>
          </tr>
          <tr>
            <th class="bg">TXN ID</th>
            <th class="bg" align="center">Status</th>
            <th class="bg" align="center">Date</th>
            <th class="bg">IPN data</th>
          </tr>
        </thead>
        <tbody>
<?php foreach($sf_data->getRaw('transactions') as $transaction):?>
<?php $ipn_data = unserialize($transaction->ipn_data);?>
          <tr>
            <td class="data"><?php echo $transaction->txn_id;?></td>
            <td class="data" align="center"><?php echo $transaction->status ?></td>
            <td class="data" align="center"><?php echo strftime('%d-%b-%Y<br />%H:%Mh', strtotime($transaction->created_at))  ?></td>
            <td class="data" width="90%">
            <div class="question">display</div>
            <div class="ipn_data">
            <table cellpadding="0" cellspacing="0" class="styled">
              <tbody>
              <tr>
                <th>Payment</th>
                <td class="data" style="font-family: Courier New;">status=<?php echo $ipn_data['payment_status'];?> | currency=<?php echo $ipn_data['mc_currency'];?> | gross=<?php echo $ipn_data['mc_gross'];?> | fee=<?php echo $ipn_data['mc_fee'];?> | type=<?php echo $ipn_data['payment_type'];?> | date=<?php echo $ipn_data['payment_date'];?></td>
              </tr>
              <tr>
                <th>Payer</th>
                <td class="data" style="font-family: Courier New;">firstname=<?php echo $ipn_data['first_name'];?> | lastname=<?php echo $ipn_data['last_name'];?> | email=<?php echo $ipn_data['payer_email'];?> | id=<?php echo $ipn_data['payer_id'];?> | status=<?php echo $ipn_data['payer_status'];?></td>
              </tr>
              <tr>
                <th>Address</th>
                <td class="data" style="font-family: Courier New;">name=<?php echo $ipn_data['address_name'];?> | street=<?php echo $ipn_data['address_street'];?> | zip=<?php echo $ipn_data['address_zip'];?> | city=<?php echo $ipn_data['address_city'];?> | state=<?php echo $ipn_data['address_state'];?> | country=<?php echo $ipn_data['address_country'];?> | code=<?php echo $ipn_data['address_country_code'];?> | status=<?php echo $ipn_data['address_status'];?></td>
              </tr>
              </tbody>
            </table>
            </div>
            </td>
          </tr>
<?php endforeach;?>
        <tbody>
      </table>

      <a href="<?php echo $reservationUrl ?>">go to reservation</a><br />
      <?php echo $reservationUrl ?>
<script>
$(function(){
	$('div.ipn_data').toggle(false);
	$('div.question').contents().wrap('<a href="#" onclick="return false;" class="view view-plus"></a>');
  $('a.view').each(function(i,e) { e.onclick = function() {$(this).parent().next().toggle(); $(this).toggleClass('view-minus');}});
})
</script>