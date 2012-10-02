<div class="man clearfix">
	
	<h3 class="man-name"><?=$man['name'].' '.$man['surname']?></h3>
	
	<h4 class="man-job"><?=$man['job']?></h4>
	
	<div class="man-description"><?=$man['description']?></div>
	
	<?php if ( !empty($man['curriculum']) ) { ?>
	<div class="man-curriculum">
	Curriculum Vitae completo: <a href="<?= ROOT . 'media/pdf/' . $man['curriculum']?>"><?=$man['curriculum']?></a>
	</div>
	<?php } ?>
</div>