<h2>Annunci</h2>

<a class="action create" href="<?=ROOT?>backoffice/<?=$table_name?>/create">Aggiungi nuovo annuncio</a>

<?php

if ( isset($_POST['submit']) ) {
	
	// hidden fields
	$action			= $_POST['action'];
	$_id 			= isset($_POST['id']) ? $_POST['id'] : 0;
	
	// fields
	$type_id 		= isset($_POST['type_id']) ? $_POST['type_id'] : '00';
	$contract_id	= (int) (isset($_POST['contract_id']) ? $_POST['contract_id'] : 0);
	$location_id 	= (int) (isset($_POST['location_id']) ? $_POST['location_id'] : 0);
	$price			= isset($_POST['price']) ? euroToDecimal($_POST['price']) : 0.00;
	$surface 		= (int) (isset($_POST['surface']) ? $_POST['surface'] : 0);		
	$isPublished 	= (int) (isset($_POST['isPublished']) ? 1 : 0);
	$isUnderConstruction = (int) (isset($_POST['isUnderConstruction']) ? 1 : 0);	
	$description	= isset($_POST['description']) ? trim($_POST['description']) : '';
	$lat			= (float) (isset($_POST['lat']) ? $_POST['lat'] : 0);
	$lng			= (float) (isset($_POST['lng']) ? $_POST['lng'] : 0);
	$reference 		= $user->initials . $type_id;
	$reference	   .= empty($_id) ? '' : $_id;	

	$attributes = array();	
	$attributes_limit = 20;
	for ($i=1; $i <= $attributes_limit; $i++) {
	
		$_name = "attribute_name_$i";
		$_value = "attribute_value_$i";
		
		if ( isset($_POST[$_name]) && isset($_POST[$_value]) ) {
		
			if ( $_POST[$_name] > 0 && $_POST[$_value] > 0 ) {
			
				$attributes[$_POST[$_name]] = $_POST[$_value];
			}
		}
	}
	// binding SQL data
	$sql_data = array(
		'_id'			=> $_id,
		'type_id'		=> $type_id,
		'location_id' 	=> $location_id,
		'contract_id'	=> $contract_id,
		'surface'		=> $surface,
		'price'			=> $price,
		'isPublished'	=> $isPublished,
		'isUnderConstruction' => $isUnderConstruction,
		'description'	=> $description,
		'attributes'	=> json_encode(array_unique($attributes)),
		'lat'			=> $lat,
		'lng'			=> $lng,
		'reference'		=> $reference
	);

	if ( $action == 'create' ) {
		// INSERT
		$query_string = "INSERT INTO `$table_name` (`type_id`, `location_id`, `contract_id`, `surface`, `price`, `isPublished`, `isUnderConstruction`, `description`, `attributes`, `creationDate`, `lat`, `lng`, `reference`) VALUES (:type_id, :location_id, :contract_id, :surface, :price, :isPublished, :isUnderConstruction, :description, :attributes, NOW(), :lat, :lng, :reference)";	
		$positive = $create_positive;
		$negative = $create_negative;
		unset($sql_data['_id']);
	}
	else 
	if ( $action == 'update' ) {
		// UPDATE
		$query_string = "UPDATE `$table_name` SET `type_id`=:type_id, `location_id`=:location_id, `contract_id`=:contract_id, `surface`=:surface, `price`=:price, `isPublished`=:isPublished, `isUnderConstruction`=:isUnderConstruction, `description`=:description, `attributes`=:attributes, `lat`=:lat, `lng`=:lng, `reference`=:reference
		WHERE `_id`=:_id";
		$positive = $update_positive;
		$negative = $update_negative;	
	} 
	else {
		die('Azione non valida: ' . htmlentities($action));
	}

	// executing statement
	$statement = $db->prepare($query_string);
	
	if ( $statement->execute($sql_data) ) {
		$response = $positive;
		
		if ( $hidden_id <= 0 ) { // $action == 'create'
			$last_id = sprintf("%04d", $db->lastInsertId()); // get last inserted id filled with 4 zeros
			$reference.= $last_id;
			$update_reference_query = "UPDATE `properties` SET `reference`='{$reference}' WHERE `_id`='{$last_id}'";
			$db->query($update_reference_query);
		}
		
	} else {
		$response = $negative;
	}
	$id = $action == 'create' ? $db->lastInsertId() : $_id;
	$response.= " (ID = $id)";
}