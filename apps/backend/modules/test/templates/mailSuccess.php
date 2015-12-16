
<?php foreach($sf_data->getRaw('templates') as $filename => $template):?>
<div style=" text-align: left;font-weight: bold; padding: 2px 8px ; margin: 0px; background-color: #2E3091; color: #DDD;"><?php echo $filename;?></div>
<?php if($template['type'] == 'text'):?>
<pre style="background-color: #FFF;text-align: left; margin: 0px;"><?php echo $template['source'];?></pre>
<?php else:?>
<iframe width="100%" height="300" src="/tmp/<?php echo $filename;?>"></iframe>
<div style=" text-align: left;border-top: 1px solid 999; background-color: #FFF;"><?php echo $template['source'];?></div>
<?php endif;?>
<?php endforeach;?>
