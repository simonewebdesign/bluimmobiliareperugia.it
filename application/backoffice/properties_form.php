<?php /* form injected via AJAX */

/* debug
var_dump($template_name);
var_dump($table_name);
var_dump($action);
var_dump($id);
//*/

include_once '../config/paths.php';
include_once FUNC . 'euro.php';
include_once CFG . 'database.php';
include_once LIB . 'db.php';

$types_db 			= $db->query("SELECT * FROM `types` ORDER BY `name` ASC");
$contracts_db 		= $db->query("SELECT * FROM `contracts` ORDER BY `name` ASC");
$comuni				= $db->query("SELECT * FROM `comuni` ORDER BY `nome` ASC");

if ( $action == 'update' ) {

	$object_db = $db->query("SELECT * FROM `$table_name` WHERE `_id`={$id}");
	$object = $object_db->fetchObject();
	/* debug
	var_dump($object);
	//*/
	$selected_comune_query = "SELECT comuni._id
	FROM comuni
	LEFT JOIN frazioni ON frazioni.id_comune = comuni._id
	WHERE frazioni._id = {$object->location_id}
	LIMIT 1";
	$selected_comune_db = $db->query($selected_comune_query);
	$selected_comune = $selected_comune_db->fetchObject();
	if (!$selected_comune) {
		$selected_comune = new stdClass;
		$selected_comune->_id = 0;
	}
	/* debug
	var_dump($selected_comune);
	//*/
}
?>

<form method=POST action="<?=ROOT?>backoffice/<?=$table_name?>">

	<fieldset>
	
		<legend>Annuncio Immobiliare</legend>

		<p class=clearfix>
			<label for=type_id>Tipologia immobile</label>
			<select id=type_id name=type_id>
				<option value=0 disabled>Seleziona...</option>			
			<?php while ( $type = $types_db->fetchObject() ) { ?>
				<option value="<?=$type->_id?>"<?=(isset($object->type_id) && $type->_id == $object->type_id) ? ' selected' : ''?>><?=$type->name?></option>
			<?php } ?>
			</select>
		</p>
		
		<p class=clearfix>
			<label for=contract_id>Contratto</label>
			<select id=contract_id name=contract_id>
				<option value=0 disabled>Seleziona...</option>			
			<?php while ( $contract = $contracts_db->fetchObject() ) { ?>
				<option value="<?=$contract->_id?>"<?=(isset($object->contract_id) && $contract->_id == $object->contract_id) ? ' selected' : ''?>><?=$contract->name?></option>
			<?php } ?>
			</select>
		</p>

		<p class=clearfix>
			<label for=id_comune>Comune</label>
			<select id=id_comune name=id_comune>
				<option value=0 disabled>Seleziona...</option>			
			<?php while ( $comune = $comuni->fetchObject() ) { ?>	
				<option value="<?=$comune->_id?>"<?=( $action == 'update' && $comune->_id == $selected_comune->_id ) ? ' selected' : ''?>><?=$comune->nome?></option>
			<?php } ?>
			</select>
		</p>
		
		<p class=clearfix id=placeholder_frazione>
			<input type=hidden name=location_id value=<?=isset($object->location_id) ? $object->location_id : 0?>>
		</p>

		<p class=clearfix>
			<label for=price>Prezzo</label>
			<input id=price name=price type=text value="<?=isset($object->price) ? euro($object->price, 0, false) : 0?>" size=10 maxlength=20 dir=rtl>&nbsp;&euro;&nbsp;&nbsp;<small>(lasciare a zero per <i>Trattativa riservata in ufficio</i>)</small>
		</p>
		
		<p class=clearfix>
			<label for=surface>Superficie</label>
			<input id=surface name=surface type=text value="<?=isset($object->surface) ? $object->surface : 0?>" size=5 maxlength=5 dir=rtl> <small>m<sup>2</sup></small>
		</p>
		
		<p class=clearfix>
			<input id=isPublished name=isPublished type=checkbox<?=empty($object->isPublished) ? '' : ' checked'?>>
			<label for=isPublished>Pubblica l'annuncio</label>
		</p>

		<p class=clearfix>
			<input id=isUnderConstruction name=isUnderConstruction type=checkbox<?=empty($object->isUnderConstruction) ? '' : ' checked'?>>
			<label for=isUnderConstruction>Questo immobile è in cantiere</label>
		</p>			
		
		<p>
			<label for=description>Descrizione</label>
			<textarea id=description name=description rows=15 cols=50><?=isset($object->description) ? $object->description : ''?></textarea>
		</p>
		
	</fieldset>

	<fieldset>
	
		<legend>Attributi <small>(facoltativi)</small></legend>
		
		<div id=attributes-container>
			<?php

			$attributes_names_query = "
			SELECT _id, name
			FROM `attributes_names` 
			ORDER BY `name` ASC";
			$attributes_names_db = $db->query($attributes_names_query);
			$attributes_names = $attributes_names_db->fetchAll(PDO::FETCH_ASSOC); // I'm using this because there's no way to reset a PDOStatement pointer.

			//var_dump($attributes_names);
			
			$json_attributes = $action == 'update' ? json_decode($object->attributes) : array();

			if ( !empty($json_attributes) ) {
				
				$i=1;
				foreach( $json_attributes as $name => $value ) {
					include BO . 'attributes_select.php';
					$i++;
				}

			}
			?>
		</div>
		
		<p class="attributes clearfix mock" title="0">
			<select class="name" name="attribute_name_x">
				<option value=0>Seleziona attributo...</option>
				<?php
				reset($attributes_names);
				foreach ( $attributes_names as $attribute_name ) {
					echo "
					<option value={$attribute_name['_id']}>
						{$attribute_name['name']}
					</option>
					";
				}
				?>
			</select>
			<select class="value" name="attribute_value_x"></select>
		</p>
		
		<a class="action add attribute">Aggiungi attributo</a>
		
	</fieldset>

	<fieldset>
	
		<legend>Posizione sulla mappa</legend>	
	
		<div>
		  <input id="searchTextField" type="text" size="50" placeholder="Digita un indirizzo...">
		  <input type="radio" name="type" id="changetype-all" checked="checked" style="visibility:hidden;">

<!--
		  <label for="changetype-all">Tutto</label>

		  <input type="radio" name="type" id="changetype-establishment">
		  <label for="changetype-establishment">Stabilimenti</label>

		  <input type="radio" name="type" id="changetype-geocode">
		  <label for="changetype-geocode">Località</label>
-->
		  </div>
		
		<div id="map_canvas"></div>
		
		<input type=hidden name="lat" id="lat" value=<?=isset($object->lat) ? $object->lat : 0?>>
		<input type=hidden name="lng" id="lng" value=<?=isset($object->lng) ? $object->lng : 0?>>
		
		<!-- asynchronous loading of google maps APIs -->
		<script src="<?=ROOT?>js/maps.js"></script>
		
	</fieldset>

	<p class=clearfix>
		<input name=submit type=submit value=Invio>
	</p>

	<!-- hidden fields -->
	<input type=hidden name=action value=<?=$action?>>
	<input type=hidden name=id value=<?=$id?>>
	
</form>