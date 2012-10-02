<?php

//$items = $all_properties;

$rss['channel']['title'] 		= $settings['site']['name'];
$rss['channel']['link'] 		= ABSOLUTE_ROOT;
$rss['channel']['description'] 	= 'Annunci Case, Immobili in Affitto e in Vendita a Perugia.';
$rss['channel']['language'] 	= 'it-it';
$rss['channel']['pubDate'] 		= 'Sat, 23 Jun 2012 09:00:00 GMT';
$rss['channel']['lastBuildDate'] = date('D, j M Y H:i:s') . " GMT";

while ( $property = $all_properties->fetchObject() ) {
	include INC . 'getPropertyTitle.php';
	include INC . 'getPropertyLink.php';
	$rss['channel']['item'][$property->_id]['title'] 		= $property->title;
	$rss['channel']['item'][$property->_id]['link'] 		= $property->link;
	$rss['channel']['item'][$property->_id]['description'] 	= html_entity_decode(strip_tags($property->description), ENT_COMPAT, 'UTF-8');
	$rss['channel']['item'][$property->_id]['pubDate'] 		= date('D, j M Y H:i:s', strtotime($property->creationDate)) . " GMT";
}