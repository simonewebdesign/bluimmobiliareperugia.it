<?php if ( $template['name'] != 'dove-siamo' ) { ?>
<h3>Posizione sulla mappa</h3>
<?php } ?>
<img id="google-map" src="http://maps.googleapis.com/maps/api/staticmap?center=<?=$property->lat?>,<?=$property->lng?>&zoom=<?=$settings['google_map']['zoom']?>&size=320x340&sensor=false&markers=color:blue%7C<?=$property->lat?>,<?=$property->lng?><?=$template['name'] == 'annuncio' ? '&maptype=satellite' : ''?>">