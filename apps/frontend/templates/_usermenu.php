<?php if($sf_user->isAuthenticated()):?>
  <?php echo link_to('My Reservations','@reservations');?> |
  <?php //echo link_to('My Profile','myreservations/index');?>
  <?php echo link_to('logout', '@logout');?>
<?php else:?>
  <?php echo link_to('login', '@login', array('style'=>'margin-top: 3px; height: 24px; line-height: 24px;display: inline-block;background: url(/images/signin24.png) no-repeat 0px 0; padding-left:28px; transparent;'));?>
<?php endif;?>




