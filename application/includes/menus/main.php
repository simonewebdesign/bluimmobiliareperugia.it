<?php

$menu = array(
	'' 							=> 'Home',
	'chi-siamo'  				=> 'Chi Siamo',
	'dove-siamo' 				=> 'Dove Siamo',
	'servizi' 					=> 'Servizi',
	'stime-e-perizie-gratuite' 	=> 'Stime e perizie gratuite',
	'certificazione-energetica' => 'Certificazione energetica',
//	'calcolo-imu' 				=> 'Calcolo IMU',
	'privacy'					=> 'Privacy',	
	'contatti' 					=> 'Contatti'
);

echo "<ul class=clearfix>";

foreach ( $menu as $menu_slug => $menu_entry ) {
	
	$current = $menu_slug == $template_name ?: false;
	
	echo "<li>";
		if ($current) { $menu_slug.= '#'; }
		echo '<a href="' . ROOT . $menu_slug . '"';
		if ($current) { echo ' class=current'; }
		echo '>' . $menu_entry . '</a>';
		echo '<img class=nav-separator src="' . ROOT . 'img/nav-separator.png" alt=separator>';		
	echo "</li>";

}
echo "</ul>";