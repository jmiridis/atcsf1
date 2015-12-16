<style>
div.title {font-weight: bold; font-size:10pt; color: #FFF; padding: 4px 8px; background-color: #000; font-family: Verdana;}
</style>

<?php foreach($ids as $id):?>
<?php echo link_to($id, url_for('tests/viewEmails?id='.$id)) ?>&nbsp;
<?php endforeach; ?>
<?php foreach($templates as $template):?>
<div class="title"><?php echo $template . ' / HTML'  ?> </div>
<iframe width="100%" height="90%" src="<?php echo url_for(sprintf('tests/viewEmail?id=%s&type=html&template=%s', $reservation_id, $template))?>"></iframe>
<div class="title"><?php echo $template . ' / TEXT' ?> </div>
<iframe width="100%" height="90%" src="<?php echo url_for(sprintf('tests/viewEmail?id=%s&type=text&template=%s', $reservation_id, $template))?>"></iframe>
<?php endforeach; ?>