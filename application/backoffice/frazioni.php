<h2>Frazioni</h2>

<p>Prima di aggiungere una nuova frazione, assicurati di aver già inserito il Comune a cui appartiene.</p>
<a class="action create" href="<?=ROOT?>backoffice/<?=$table_name?>/create">Aggiungi nuova frazione</a>

<?php

if ( isset($_POST['submit']) ) {
	
	// hidden fields
	$action			= $_POST['action'];
	$_id 			= isset($_POST['id']) ? $_POST['id'] : 0;
	
	// fields
	$id_comune		= (int) (isset($_POST['id_comune']) ? $_POST['id_comune'] : 0);
	$nome 			= isset($_POST['nome']) ? trim($_POST['nome']) : '';
	
	// binding SQL data
	$sql_data = array(
		'_id'			=> $_id,
		'id_comune'		=> $id_comune,
		'nome'			=> $nome,
	);
	
	if ( $action == 'create' ) {
		// INSERT
		$query_string = "INSERT INTO `$table_name` (`nome`, `id_comune`) VALUES (:nome, :id_comune)";	
		$positive = $create_positive;
		$negative = $create_negative;
		unset($sql_data['_id']);
	}	
	else 
	if ( $action == 'update' ) {
		// UPDATE
		$query_string = "UPDATE `$table_name` SET `nome`=:nome, `id_comune`=:id_comune WHERE `_id`=:_id";
		$positive = $update_positive;
		$negative = $update_negative;	
	} 
	else {
		die('Azione non valida: ' . htmlentities($action));
	}

	// executing statement
	$statement = $db->prepare($query_string);
	
	if ( $statement->execute($sql_data) ) {
		$response = $positive;
	} else {
		$response = $negative;
	}
	$id = $action == 'create' ? $db->lastInsertId() : $_id;
	$response.= " (ID = $id)";
}