<?php

$similar_properties = true;
include_once LOGIC . 'properties.php';

//var_dump($query);

if ( $properties->rowCount() > 0 ) { 
?>
<h3>Annunci simili</h3>

<?php while ( $property = $properties->fetchObject() ) {

		include LOGIC . 'similar_image.php';
		include INC . 'getPropertyTitle.php';
		include INC . 'getPropertyLink.php';
		include INC . 'similar_property.php';
		echo "<hr>";
	}
}