<?php

/*                *\
* CUSTOM BOOTSTRAP *
*/       /*       */

$template_name  = isset($get[0]) ? $get[0] : false;

$css .= add_css('modules/navbar');

if ( empty($template_name) || $template_name == 'ricerca' ) { // default template, or ricerca

	$css .= add_css('classes/number-circle');
	$css .= add_css('classes/list');
	$css .= add_css('classes/property-preview');
	$css .= add_css('modules/filters');
	
	// begin paging vars
	$page 				= (int) (isset($get[8]) ? $get[8] : 1);
	$results_per_page 	= (int) $settings['results']['default_limit'];
	$start_from			= $page * $results_per_page - $results_per_page;
	$paging_string 		= " LIMIT $start_from, $results_per_page";
	/* debug
	var_dump($page);
	var_dump($results_per_page);
	var_dump($start_from);
	var_dump($paging_string);
	//*/
	// end paging vars

} // end default template, or ricerca

if ( $template_name == 'annuncio' && isset($get[1]) ) {

	$property_id = $get[1];

	// begin for SEO (property in title)
	include_once LOGIC . 'property.php';
	include_once INC . 'getPropertyTitle.php';
	$template['title'] = $property->title;
	$template['metaDescription'] = strip_tags($property->description);
	$metaKeywords = explode(' ', $property->title);
	$metaKeywords = implode(', ', $metaKeywords);
	$template['metaKeywords'] = $metaKeywords . ', ' . $template['metaKeywords'];
	// end for SEO (property in title)
	
	$css .= add_css('classes/property');
	$css .= add_css('classes/property-similar');
	$css .= add_css('modules/message-form');
	$css .= add_css('modules/googleMap');
}

if ( $template_name == 'backoffice' && isset($get[1]) ) {

	$table_name = $get[1];
	
	if ($table_name == 'images') {
		$css .= add_css('classes/backoffice-image');
	}	
}


if ( $template['name'] == 'contatti' ||
     $template['name'] == 'stime-e-perizie-gratuite' ||	
	 $template['name'] == 'certificazione-energetica'
	 //$template['name'] == 'calcolo-imu'
   ) {
	$css .= add_css('modules/contact-form');
}


if ($template['name'] == 'ricerca') {

    $type_id   = $get[1];
    $id_comune = isset($get[4]) ? $get[4] : false;

    if ($id_comune) {

        // begin for SEO (comune in title)
        $comune_db = $db->prepare("SELECT nome FROM comuni WHERE _id=?");
        $comune_db->execute(array($id_comune));
        $comune = $comune_db->fetchObject();
        $template['title'] = "Annunci Immobiliari dal Comune di " . $comune->nome;
        // end for SEO (comune in title)

    } else if ($type_id > 0) {

        // begin for SEO (type in title)
        $type_db = $db->prepare("SELECT `name` FROM `types` WHERE _id=?");
        $type_db->execute(array($type_id));
        $type = $type_db->fetchObject();
        $template['title'] = $type->name . " a Perugia";
        // end for SEO (type in title)
    }

} // end template ricerca