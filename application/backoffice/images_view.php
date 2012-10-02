<h3>Immobile ID = <?=$id?></h3>

<h4>Doppio click sull'immagine per eliminarla.</h4>

<?php

include_once '../config/paths.php';
include_once '../config/database.php';
include_once '../library/db.php';

$images = $db->query("SELECT * FROM images WHERE property_id=$id");

while ( $image = $images->fetchObject() ) {
	
	if ( is_file( PREVIEW . $image->name) ) {
		include BO . 'image.php';
	}
}