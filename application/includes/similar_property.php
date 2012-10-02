<div class="property-similar clearfix">

	<a class="property-similar-title" href=<?=$property->link?>><?=$property->title?></a>
	
	<a class="property-similar-image" href=<?=$property->link?>>
		<img src="<?=ROOT . PREVIEW . $main_image->name?>" alt="<?=$property->title?>">
	</a>	
	
	<div class="property-similar-description">
		<?php
		$limit = 110;
		$break = ' ';
		$read_all = '... <a class=read-more href="' . $property->link . '">continua&nbsp;»</a>';
		echo truncateLongText($property->description, $limit, $break, $read_all);
		?>
	</div>
	
</div>