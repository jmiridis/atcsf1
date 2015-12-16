<table cellpadding="0" cellspacing="0" >
  <tr>
    <td style="width: 150px; text-align:center; padding: 0px 0px; "><img src="/images/atc-star-100.png" width="100" height="100" alt="" border="0" /></td>
    <td style="width: 600px; text-align: center;">
    <div style="margin: 0px 0px 12px 0px;"><img src="/images/logo-atc.png" width="486" height="15" alt="" border="0" /></div>
    <div><img src="/images/motto.png" width="413" height="11" alt="" border="0" /></div></td>
  </tr>
</table>


<?php if($sf_user->isAuthenticated()):?>
    <div style="text-align:right;padding: 2px 15px;"> Welcome: <?php echo $sf_user->getGuardUser()->getFirstName() . ' ' . $sf_user->getGuardUser()->getLastName();?>&nbsp;|&nbsp;<?php echo link_to('logout', '@logout');?></div>
<?php else:?>
  <div align="right" style="padding-right: 30px;">
  <?php //echo link_to('login', '@login', array('style'=>'margin-top: 3px; height: 24px; line-height: 24px;display: inline-block;background: url(/images/signin24.png) no-repeat 0px 0; padding-left:28px; transparent;'));?>
</div>
<?php endif;?>
