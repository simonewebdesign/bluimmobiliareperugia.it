<!-- PHP Template name: dove-siamo -->

<div id=middle-column role=main class=left>

	<?php include_once INC . 'h1h2.php';	
	/* coordinate via giuseppe lunghi 21 perugia */
	$property = new stdClass;
	$property->lat = '43.088072';
	$property->lng = '12.438755';
	include_once INC . 'googleMap.php';
	?>
	
</div>
<div id=right-column class=left role=complementary>
<?php include_once INC . 'contacts_data.php' ?>	
</div>

<img src="<?=ROOT?>img/dove-siamo.jpg" width=1000 alt="Blu immobiliare dove siamo" style="margin-bottom:30px;">