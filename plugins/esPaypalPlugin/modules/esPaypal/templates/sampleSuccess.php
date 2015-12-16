<h1>Sample : Pay with PayPal</h1>
<p>The button "Pay with PayPal" below will send you to PayPal using the following information.</p>

<table>
<?php foreach($button as $key => $value):?>
<tr><td><?php echo $key;?></td><td><?php echo $value;;?></td></tr>
<?php endforeach;?>
</table>
<br />
<?php echo htmlspecialchars_decode($button->renderEncrypted())?>
