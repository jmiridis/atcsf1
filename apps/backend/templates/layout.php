<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <link href="/css/admin.css" media="screen" type="text/css" rel="stylesheet">
    <?php include_javascripts() ?>
  </head>
  <body>
  <div id="wrapper">
    <table cellpadding="0" cellspacing="0" id="layout-table">
      <tr>
        <td style="height: 130px;" valign="bottom"><?php include_partial('global/header');?></td>
      </tr>
      <tr>
        <td valign="top" style="padding: 15px"><?php echo $sf_content ?></td>
      </tr>
      <tr>
        <td style="height: 30px;"><?php include_partial('global/footer');?></td>
      </tr>
    </table>
  </div>  </body>
</html>
