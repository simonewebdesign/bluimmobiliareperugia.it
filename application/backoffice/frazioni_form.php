<?php /* form injected via AJAX */

/* debug
var_dump($template_name);
var_dump($table_name);
var_dump($action);
var_dump($id);
//*/

include_once '../config/paths.php';

include_once CFG . 'database.php';
include_once LIB . 'db.php';

$comuni_db = $db->query("SELECT * FROM comuni");

if ( $action == 'update' ) {
	
	$object_db = $db->query("SELECT * FROM `$table_name` WHERE `_id`={$id}");
	$object = $object_db->fetchObject();
	/* debug
	var_dump($object);
	//*/
}

?>

<form method=POST action="<?=ROOT?>backoffice/<?=$table_name?>">

	<fieldset>
	
		<!--<legend></legend>-->

		<p class=clearfix>
			<label for=id_comune>Comune di</label>
			<select id=id_comune name=id_comune>
			<?php while ( $comune = $comuni_db->fetchObject() ) { ?>
				<option value=<?=$comune->_id?>><?=$comune->nome?></option>
			<?php } ?>			
			</select>
		</p>
		
		<p class=clearfix>
			<label for=nome>Frazione</label>
			<input id=nome name=nome type=text required value="<?=isset($object->nome) ? $object->nome : ''?>" maxlength=100>
		</p>
		
		<p class=clearfix>
			<input name=submit type=submit value=Invio>
		</p>
		
	</fieldset>
	
	<!-- hidden fields -->
	<input type=hidden name=action value=<?=$action?>>
	<input type=hidden name=id value=<?=$id?>>
	
</form>