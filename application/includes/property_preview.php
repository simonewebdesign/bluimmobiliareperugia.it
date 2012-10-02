<?php
include INC . 'getPropertyTitle.php';
include INC . 'getPropertyLink.php';
?>

<div class="property-preview clearfix">
	
	<a class="image" href="<?=$property->link?>">
		<img class="lazy" src="<?=ROOT?>img/uploaded/preview/no-preview.jpg" data-original="<?=ROOT . PREVIEW . $main_image->name?>" alt="<?=$property->title?>">
	</a>
	
	<h4><a class="title" href="<?=$property->link?>"><?=$property->title?></a></h4>
	
	<div class="description">
		<?php
		$limit = 210;
		$break = ' ';
		$read_all = '... <a class=read-more href="' . $property->link . '">continua&nbsp;»</a>';
		echo truncateLongText($property->description, $limit, $break, $read_all);
		?>
	</div>
	
</div>