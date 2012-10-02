<?php
include_once '../config/database.php';
include_once '../library/db.php';

$bool = (int) (isset($params[4]) ? $params[4] : 0);
$query = "UPDATE $table_name SET isPublished=:isPublished WHERE _id=:_id";

$sql_data = array(
	'_id' => $id,
	'isPublished' => $bool
);

$statement = $db->prepare($query);

if ( $statement->execute($sql_data) ) {

	if ($bool) {
		echo "<span class='icon true'>L'annuncio è stato pubblicato. (ID = $id)</span>";	
	} else {
		echo "<span class='icon false'>L'annuncio è stato nascosto. (ID = $id)</span>";	
	}

} else {

	echo "<span class='icon error'>Errore: lo stato di pubblicazione dell'oggetto non è stato modificato. (ID = $id)</span>";
}