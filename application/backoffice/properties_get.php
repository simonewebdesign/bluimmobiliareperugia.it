<?php/*$id = id della frazione (che è anche il $property->location_id)$property_id = id della proprietà*/include_once '../config/database.php';include_once '../library/db.php';if ($id > 0) {	$frazioni = $db->query("SELECT * FROM `frazioni` WHERE id_comune=$id ORDER BY nome");	//$selected_frazione = $db->query("");} else die("ERRORE FATALE: ID FRAZIONE <= 0");if ( $frazioni->rowCount() <= 0 ) 	die("<span style='color:red;font-weight:bold;'>ATTENZIONE!</span> Nel comune da te selezionato non ci sono frazioni. Devi inserirne almeno una per continuare.");/*$property_id = isset($params[4]) ? $params[4] : 0;if ($property_id > 0) {	$property_db = $db->query("SELECT `location_id` FROM `properties` WHERE `_id`=$property_id LIMIT 1");	$property_location_id = $db->fetchObject();} else {	$property_location_id = 0;}*/?>	<label for=location_id>Frazione</label>	<select id=location_id name=location_id>		<option value=0 disabled>Seleziona...</option>	<?php while ( $frazione = $frazioni->fetchObject() ) { ?> 			<option value="<?=$frazione->_id?>"><?=$frazione->nome?></option>	<?php } ?>	</select><?php //<?=( $action == 'update' && $frazione->_id == $property_location_id ) ? ' selected' : ''?>