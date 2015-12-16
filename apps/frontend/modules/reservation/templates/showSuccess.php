<style>div.option {color: #444; font-weight: bold; padding-bottom: 4px;}</style>
<div class="page_title">Reservation #<?php echo $reservation->uniqid;?></div>
<div class="section-box">
<div class="section-title">Payment Details</div>
<div class="section-content">
<?php switch($reservation->status):?>
<?php case 'open':      include_partial('status_open',      array('button'=>$button)); break;?>
<?php case 'pending':   include_partial('status_pending',   array('ipn_data'=>$ipn_data)); break;?>
<?php case 'cancelled': include_partial('status_cancelled', array()); break;?>
<?php case 'refund':    include_partial('status_refund',    array()); break;?>
<?php case 'paid':      include_partial('status_paid',      array('ipn_data'=>$ipn_data)); break;?>
<?php case 'closed':    include_partial('status_closed',    array()); break;?>
<?php endswitch;?>
</div>
</div>
<?php include_partial('reservation/details', array('reservation'=>$reservation));?>

