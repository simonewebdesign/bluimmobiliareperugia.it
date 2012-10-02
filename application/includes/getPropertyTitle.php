<?php

if ( !empty($property) ) {
	$property->title = $property->type . ' in ' . $property->contract;
	
	if ( startsWith($property->location, 'Zona') || startsWith($property->location, 'zona') ) {
		$property->title.= ' in ';
	} else
	if ( startsWith($property->location, 'a') ||
		 startsWith($property->location, 'e') ||
		 startsWith($property->location, 'i') ||
		 startsWith($property->location, 'o') ||
		 startsWith($property->location, 'u') ||
		 startsWith($property->location, 'A') ||
		 startsWith($property->location, 'E') ||
		 startsWith($property->location, 'I') ||
		 startsWith($property->location, 'O') ||
		 startsWith($property->location, 'U') ){
		$property->title.= ' ad ';	 
	} else if ( startsWith($property->location, 'centro') || startsWith($property->location, 'Centro') ) {	
		$property->title.= ' al ';	
	} else {
		$property->title.= ' a '; 
	}

	$property->title.= $property->location;
	
	// specifying the Comune (only if it's not Perugia).
	if ( $property->comune != 'Perugia' ) {
		$property->title.= ' di ';
		$property->title.= $property->comune;
	}
}