<table cellpadding="0" cellspacing="8">
  <tr>
    <td>From</td>
    <td><?php echo $email_address;?></td>
  </tr>
  <tr>
    <td valign="top">Message</td>
    <td><?php echo str_replace("\n", '<br/>', $message);?></td>
  </tr>
</table>
