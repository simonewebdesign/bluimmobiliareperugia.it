<style>

	/* Demo styles */
	.content{
		color:#777;
		font:12px/1.4 "helvetica neue",arial,sans-serif;
		width:640px;
		margin:0 auto;
	}
	a {
		color:#22BCB9;
		text-decoration:none;
	}

	/* This rule is read by Galleria to define the gallery height: */
	#galleria{height:480px}

</style>

<div class="content">

	<div id="galleria">

	<?php
	
	include_once LOGIC . 'images.php';
	
	while ( $image = $images->fetchObject() ) {
	
		$portrait = PORTRAIT . $image->name;
		$preview = PREVIEW . $image->name;
	
		if ( is_file($portrait) && is_file($preview) ) {
	?>
		<a href="<?=ROOT . $portrait?>">
			<img data-title="<?=$image->title?>"
				 data-description="<?=$image->description?>"
				 src="<?=ROOT . $preview?>">
		</a>
	<?php
		}
	}	
	?>

	</div>
</div>