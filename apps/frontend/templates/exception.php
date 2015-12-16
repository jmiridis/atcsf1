<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <link rel="icon" type="image/png" href="/images/favicon.png"> <title>
    <?php if(has_slot('title')):?>
      <?php include_slot('title');?>
    <?php else: ?>
    American Transfers Cancun
    <?php endif;?>
    </title>

    <link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/exception.css" />

    <meta name="description" content="<?php include_slot('meta_description') ;?>" />
  </head>
  <body>
  <div id="wrapper">
    <table cellpadding="0" cellspacing="0" id="layout-table">
      <tr>
        <td style="height: 32px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="height: 127px; text-align: center;" >
          <table cellpadding="0" cellspacing="20" align="center">
            <tr>
              <td align="right"><img src="/images/atc-star-100.png" width="100" height="100" alt="" border="0" /></td>
              <td align="left"><img src="/images/logo-atc.png" width="486" height="15" alt="" border="0" /></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td valign="top"><?php echo $sf_content ?></td>
      </tr>
      <tr>
        <td style="height: 30px;"><?php include_partial('global/footer');?></td>
      </tr>
    </table>
  </div>
  </body>
</html>
