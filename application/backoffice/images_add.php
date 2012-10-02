<?php
// questo file poteva essere images_create.php ma ho preferito chiamarlo così perché in realtà non viene chiamato nessun create come avviene di solito, ma viene inserita una nuova immagine in base all'id dell'immobile.

	// Including Database
	//include_once '../cfg/database.php';
	//include_once '../lib/db.php';
	
	//$fruit_db = $db->query("SELECT * FROM fruits WHERE _id=$id");
	//$fruit = $fruit_db->fetchObject(); // or fetchALL(PDO::FETCH_ASSOC); if you prefer.


if ($id) { // ID immobile settato

	include_once '../config/paths.php';	
	
	echo "<p>";
		echo "<b>ID Immobile selezionato = $id</b>";
	echo "</p>";
	
	include_once BO. 'images_form.php';
}

?>