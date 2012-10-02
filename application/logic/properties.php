<?php

// $get[0] === $template_name
// the following vars are needed for all templates, even the default
$type_id 		= isset($get[1]) ? $get[1] : 0;
$contract_id 	= (int) (isset($get[2]) ? $get[2] : 0);
$id_frazione	= (int) (isset($get[3]) ? $get[3] : 0);
$id_comune		= (int) (isset($get[4]) ? $get[4] : 0);

$prices			= isset($get[5]) ? explode("_", $get[5]) : "0_0";
$min_price 		= (int) (isset($prices[0]) ? $prices[0] : 0);
$max_price 		= (int) (isset($prices[1]) ? $prices[1] : 0);

$surfaces		= isset($get[6]) ? explode("_", $get[6]) : "0_0";
$min_surface 	= (int) (isset($surfaces[0]) ? $surfaces[0] : 0);
$max_surface	= (int) (isset($surfaces[1]) ? $surfaces[1] : 0);

$isUnderConstruction = (int) (isset($get[7]) ? $get[7] : 0);
$page			= (int) (isset($get[8]) ? $get[8] : 1);

$query = "";

$unlimited_query = "SELECT p . * , t.`name` AS `type` , c.`name` AS `contract` , f.`nome` AS `location`, com.`nome` AS `comune`
FROM (
(
(
(
`properties` AS p
LEFT JOIN `types` AS t ON t.`_id` = p.`type_id`
)
LEFT JOIN `frazioni` AS f ON f.`_id` = p.`location_id`
)
LEFT JOIN `comuni` AS com ON com.`_id` = f.`id_comune`
)
LEFT JOIN `contracts` AS c ON c.`_id` = p.`contract_id`
)
WHERE p.`isPublished`=1
AND p.`isDeleted`<= 0 "; // it's just the "unlimited" query string.

if ($template['name'] == 'ricerca') {
	// filters
	if ( $type_id > 0 ) {
		$unlimited_query.= "AND p.`type_id` = '$type_id' ";
	}
	if ( $id_comune > 0 ) {
		$unlimited_query.= "AND com.`_id` = $id_comune ";
	}
	if ( $id_frazione > 0 ) {
		$unlimited_query.= "AND p.`location_id` = $id_frazione ";
	}
	if ( $contract_id > 0 ) {
		$unlimited_query.= "AND p.`contract_id` = $contract_id ";
	}
	if ( $min_price > 0 ) {
		$unlimited_query.= "AND p.`price` >= '$min_price' ";
	}
	if ( $max_price > 0 ) {
		$unlimited_query.= "AND p.`price` <= '$max_price' ";
	}
	if ( $min_surface > 0 ) {
		$unlimited_query.= "AND p.`surface` >= $min_surface ";
	}
	if ( $max_surface > 0 ) {
		$unlimited_query.= "AND p.`surface` <= $max_surface ";
	}
	if ( $isUnderConstruction > 0 ) {
		$unlimited_query.= "AND p.`isUnderConstruction` = 1 ";
	}
}

if ($template['name'] == 'annuncio' && $similar_properties) {
	// this is just for the similar properties.
	$unlimited_query.= "
		AND p.`type_id` = {$property->type_id} 
		AND p.`contract_id` = {$property->contract_id}
		AND p.`location_id` = {$property->location_id}
		AND p.`_id` != {$property->_id} ";
}

$unlimited_query.= "ORDER BY p.creationDate DESC ";

if ($template['name'] == 'annuncio' && $similar_properties) {
	// we don't need paging, this query is for similar properties.
	$unlimited_query.= "LIMIT {$settings['results']['similar_properties_limit']}";
	$query = $unlimited_query;
} else {
	// we NEED paging.
	$query = $unlimited_query . $paging_string;
}

//var_dump($query);
//var_dump($paging_string);

$all_properties = $db->query($unlimited_query); // unlimited properties. They're needed for pagination AND for rss.php

if (!empty($query)) {
	$properties = $db->query($query);
}