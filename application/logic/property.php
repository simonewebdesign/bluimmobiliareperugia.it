<?php

$published_property_query = "SELECT p.*, t.`name` AS `type`, c.`name` AS `contract`, f.`nome` AS `location`, com.`nome` AS `comune`, DATE_FORMAT(p.`creationDate`, '".DATE_FORMAT_DATE."') AS `creationDate`
	FROM (
		(
			(
				(
					`properties` as p
					INNER JOIN `types` AS t ON t.`_id` = p.`type_id`
				)
				INNER JOIN `frazioni` AS f ON f.`_id` = p.`location_id`
			) 
			INNER JOIN `comuni` AS com ON com.`_id` = f.`id_comune`
		)
		INNER JOIN `contracts` AS c ON c.`_id` = p.`contract_id`
	)
	WHERE p.`isPublished`=1 AND p.`_id`='{$property_id}'
	LIMIT 1";	
$property_db = $db->query($published_property_query);
$property = $property_db->fetchObject();
//var_dump($property);

