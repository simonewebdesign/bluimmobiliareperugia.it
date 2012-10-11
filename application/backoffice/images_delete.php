<?php

// CAPOLAVORO.

include_once '../config/paths.php';
include_once CFG . 'database.php';
include_once LIB . 'db.php';

$image_name = $id;

if ($image_name) {

	$delete_db = $db->prepare('DELETE FROM images WHERE name=?');
	$delete = $delete_db->execute(array($image_name));

	if ($delete) {
		
		$delete_original = unlink(ORIGINAL.$image_name);
		$delete_portrait = unlink(PORTRAIT.$image_name);
		$delete_preview  = unlink(PREVIEW.$image_name);
		
		echo $delete_original && $delete_portrait && $delete_preview ? 
    "Immagine eliminata." : 
    "Errore durante l'eliminazione dell'immagine. Riprovare.";
		
	} else {
		echo "Errore durante l'eliminazione dell'immagine dal database: probabilmente è già stata eliminata.";
	}
	
} else {
	echo "Errore: nome dell'immagine vuoto.";
}