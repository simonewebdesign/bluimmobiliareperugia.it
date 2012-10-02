<!-- PHP Template name: ricerca -->
			
<div id=left-column role=complementary class=left>
	<?php include_once INC . 'lists/types.php' ?>
	<hr>
	<?php include_once INC . 'lists/locations.php' ?>
	<hr>
	<a id=rss href="<?=ROOT?>rss.php">
		<img src="<?=ROOT?>img/icons/rss.gif" alt="RSS feed">
	</a>
</div>
<div id=middle-column role=main class=left>
	<?php include_once INC . 'h1h2.php' ?>
	<?php include_once INC . 'forms/contract.php' ?>	
	<?php include_once INC . 'properties.php' ?>
	<?php include_once INC . 'paginator.php' ?>
</div>
<div id=right-column class=left>
	<?php include_once INC . 'forms/filters.php' ?>
	<hr>
	<?php //include_once INC . 'lists/contracts.php' ?>
	<!--<hr>-->
	<?php include_once INC . 'numProperties.php' ?>
	<hr>	
</div>
