<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <!-- _dd5gYnZmHyFO3xsBMiwjDq2s2k -->
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <title>
    <?php if(has_slot('title')):?>
      American Transfers Cancun - <?php include_slot('title');?>
    <?php else: ?>
    American Transfers Cancun
    <?php endif;?>
    </title>
    <meta name="description" content="<?php include_slot('meta_description') ;?>" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-39338512-1']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
  </head>
  <body>
  <div id="wrapper">
    <table cellpadding="0" cellspacing="0" id="layout-table">
      <tr>
        <td style="height: 130px; background: transparent url(/images/atc-header-background.jpg) no-repeat top left;" valign="bottom"><?php include_partial('global/header');?></td>
      </tr>
      <tr>
        <td valign="top">
          <table cellpadding="0" cellspacing="0" style="height: 100%;">
            <tr>
              <td id="menu"><?php include_partial('global/menu');?><br /><br />
              <div style="text-align:center;"><img src="/images/secureSiteLogo.png"  alt="" border="0" /></div>
			  </td>
              <td id="content"><div id="content-box"><?php echo $sf_content ?></div></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="height: 30px;"><?php include_partial('global/footer');?></td>
      </tr>
    </table>
  </div>
  </body>
</html>
