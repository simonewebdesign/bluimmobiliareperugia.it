<!-- PHP Template name: Annuncio -->

<?php

//include_once INC . 'h1h2.php';

$property_id = isset($get[1]) ? $get[1] : false;
$property_id = (int) (($property_id > 0) ? $property_id : false);
//var_dump($property_id);
$error_message = 'Spiacente, l\'annuncio richiesto non è disponibile.<br>Prova ad effettuare una nuova ricerca, oppure <a href="'.ROOT.'">Torna alla Home</a>.';

if ( $property_id ) {

//	include_once LOGIC . 'property.php';

	if ( !empty($property) ) {
		// showing property's details...
		?>
<div id=middle-column role=main class=left>
  <?php include_once LOGIC . 'images.php'; ?>
	<?php include_once INC . 'property.php'; ?>
	<hr>
	<?php include_once INC . 'forms/send_message.php'; ?>
</div>
<div id=right-column class=left>
	<?php include_once INC . 'googleMap.php'; ?>
	<hr>
	<?php include_once INC . 'similar_properties.php'; ?>
</div>
		<?php
		// DEBUG
		//var_dump($property);

	} else {
		// something to show/do if $property with $property_id not found in db.
		echo "<p style='margin-left:20px;'>$error_message</p>";
	}

} else {
	// something to show if $property_id is not set in URL, =0, negative, or not valid.
	echo "<p style='margin-left:20px;'>$error_message</p>";
}