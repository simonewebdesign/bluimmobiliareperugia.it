<div class="backoffice-image clearfix">
	<img src="<?=ROOT . PREVIEW . $image->name?>" title="<?=$image->name?>">
	<dl class=clearfix>
		<dt>Titolo</dt>
		<dd><?=empty($image->title) ? '<i style="color:#888">Non specificato</i>' : '<b>'.$image->title.'</b>'?></dd>
		
		<dt>Descrizione</dt>
		<dd><?=empty($image->description) ? '<i style="color:#888">Non specificata</i>' : '<small>'.$image->description.'</small>'?></dd>
	</dl>
</div>