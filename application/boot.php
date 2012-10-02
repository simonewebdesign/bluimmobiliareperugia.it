<?php

/*                *\
* CUSTOM BOOTSTRAP *
*/       /*       */

$template_name  = isset($get[0]) ? $get[0] : false;

// global stylesheets
$css.= '<link rel="stylesheet" href="' . ROOT . 'css/modules/navbar.css" media="screen">';

if ( empty($template_name) || $template_name == 'ricerca' ) { // default template, or ricerca

	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/classes/number-circle.css" media="screen">';
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/classes/list.css" media="screen">';
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/classes/property-preview.css" media="screen">';
	
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/modules/filters.css" media="screen">';		
	
	// begin paging vars
	$page 				= (int) (isset($get[8]) ? $get[8] : 1);
//	$pages				= $properties->rowCount();
	$results_per_page 	= (int) $settings['results']['default_limit'];
	$start_from			= $page * $results_per_page - $results_per_page;
	$paging_string 		= " LIMIT $start_from, $results_per_page";
	/* debug OK
	var_dump($page);
	var_dump($pages);
	var_dump($results_per_page);
	var_dump($start_from);
	var_dump($paging_string);
	//*/
	// end paging vars	
}

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
	
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/classes/property.css" media="screen">';
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/classes/property-similar.css" media="screen">';
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/modules/message-form.css" media="screen">';
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/modules/googleMap.css" media="screen">';	
}

if ( $template_name == 'backoffice' && isset($get[1]) ) {

	$table_name = $get[1];
	
	if ($table_name == 'images') {
		$css.= '<link rel="stylesheet" href="' . ROOT . 'css/classes/backoffice-image.css" media="screen">';
	}	
}

if ( $template['name'] == 'contatti' ||
     $template['name'] == 'stime-e-perizie-gratuite' ||	
	 $template['name'] == 'certificazione-energetica' ||
	 $template['name'] == 'calcolo-imu'
   ) {
	$css.= '<link rel="stylesheet" href="' . ROOT . 'css/modules/contact-form.css" media="screen">';	
}