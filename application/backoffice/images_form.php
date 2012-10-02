<?php /* form injected via AJAX */

/* debug
var_dump($template_name);
var_dump($table_name);
var_dump($action);
var_dump($id);
//*/

include_once '../config/paths.php';

if ( $action == 'update' ) {

	include_once CFG . 'database.php';
	include_once LIB . 'db.php';
	
	$object_db = $db->query("SELECT * FROM `$table_name` WHERE `_id`={$id}");
	$object = $object_db->fetchObject();
	/* debug
	var_dump($object);
	//*/
}

?>

<form method=POST action="<?=ROOT?>backoffice/<?=$table_name?>" enctype="multipart/form-data">

	<fieldset>
	
		<legend>Caricamento nuova immagine</legend>
		
		<p class=clearfix>
			<label for=image>Selezionala dal tuo PC:</label>
			<input id=image name=image type=file required> <small>(Solo GIF, JPG o PNG. Max 2 MB)</small>
		</p>
	
	</fieldset>
	
	
	<fieldset><legend>Campi facoltativi</legend>
		<p class=clearfix>
			<label for=title>Titolo</label>
			<input id=title name=title maxlength=50> <small>(Max 50 caratteri)</small>
		</p>
		<p class=clearfix>
			<label for=image_description>Descrizione</label>
			<textarea id=image_description name=image_description maxlength=200></textarea> <small>(Max 200 caratteri)</small>
		</p>
		<p class=clearfix>
			<label for=isMain>Imposta come immagine principale</label>
			<input id=isMain name=isMain type=checkbox> <!-- when checked, value = "on" -- empty($image->isMain) ? '' : ' checked' -->
		</p>
		
	</fieldset>
		
		<p class=clearfix>
			<input name=submit type=submit value=Invio>
		</p>
		
	</fieldset>
	
	<!-- hidden fields -->
	<input type=hidden name=action value=<?=$action?>>
	<input type=hidden name=id value=<?=$id?>>
	
</form>