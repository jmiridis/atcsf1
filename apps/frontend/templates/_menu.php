<?php if($sf_user->isAuthenticated()):?>
<div class="user-menu"><?php echo link_to('My Reservations', 'reservation/index');?></div>
<?php else:?>
<div style="height:30px;">&nbsp;</div>
<?php endif;?>

<ul class="menu">
  <li class="<?php echo ($sf_context->getModuleName() == 'home')? 'selected' : 'b';?>"><?php echo link_to('Home',   'home/index',   array('class'=> ($sf_context->getModuleName() == 'home')? 'selected' : 'b'));?></a></li>
  <li class="<?php echo ($sf_context->getModuleName() == 'prices')? 'selected' : 'b';?>"><?php echo link_to('Prices',   'prices/index',   array('class'=> ($sf_context->getModuleName() == 'prices')? 'selected' : 'b'));?></a></li>
  <li class="<?php echo ($sf_context->getModuleName() == 'reservation')? 'selected' : 'b';?>"><?php echo link_to('Reservation',   'reservation/new',   array('class'=> ($sf_context->getModuleName() == 'reservation')? 'selected' : 'b'));?></a></li>
  <li class="<?php echo ($sf_context->getModuleName() == 'contact')? 'selected' : 'b';?>"><?php echo link_to('Contact Us',   'contact/index',   array('class'=> ($sf_context->getModuleName() == 'contact')? 'selected' : 'b'));?></a></li>
  <li class="<?php echo ($sf_context->getModuleName() == 'faq')? 'selected' : 'b';?>"><?php echo link_to('F.A.Q.',   'faq/index',   array('class'=> ($sf_context->getModuleName() == 'faq')? 'selected' : 'b'));?></a></li>
<?php if($sf_user->isAuthenticated()):?>
<li class="b"><?php echo link_to('logout', 'home/logout', array('class'=> 'b'));?></a></li>
<?php endif;?>
</ul>
