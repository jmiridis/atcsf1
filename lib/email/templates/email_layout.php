<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php include_slot('title');?></title>
<style type="text/css">
body {background-color:#999999;color:#1D1D1D;font-family:Arial,Helvetica,sans-serif;font-size:12px; line-height: 18px;margin:0;padding:10px;}
a{color:#0F20A3;}
div.goodbye {line-height: 13px; margin-top: 20px;}
div.footer {background-color: #3C3C3C; padding: 3px 8px; color:#999; font-size: 8pt; text-align: right;}
div.section_title {background-color:#CCCCCC;margin: 15px 0px 5px 0px; padding: 1px 8px;}
div.sub_title {padding: 3px 3px 3px 15px; color: #1178C3; font-weight: bold;}
table.reservation th {padding: 2px 8px 2px 15px;color:#333333;}
</style>
</head>
<body>
<table align="center" cellpadding="0" cellspacing="0" width="600">
  <tr><td><img src="/images/mail-logo.png" width="600" height="80" alt="" border="0" /></td></tr>
  <tr>
    <td style="padding: 20px 30px 10px 30px; background-color: #FFFFFF; text-align: left;">
  	<?php echo $sf_content;?>
  	<div class="goodbye">Thanks<br />ATC Reservations<br /><a href="http://americantransferscancun.com">http://americantransferscancun.com</a></div>
		</td>
	</tr>
  <tr><td><div class="footer">Copyright &copy; 2009-2011 e-Solutions S.C.</div></td></tr>
</table>
</body>
</html>
