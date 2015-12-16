<?php if($sf_request->getParameter('param1')):?>
Test step 2<br />
<?php echo $sf_request->getParameter('param1');?>
<?php else:?>
Test step 1<br />
<a href="<?php echo $url;?>"><?php echo $url;?></a>
<?php endif;?>
