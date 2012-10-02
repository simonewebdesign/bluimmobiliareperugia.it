<h3>Tutte le Frazioni dei Comuni</h3>

<?php

$query = "SELECT f.`_id` AS ID, c.`nome` AS comune, f.nome AS frazione
FROM frazioni AS f
INNER JOIN comuni AS c ON c._id = f.id_comune";
$actions = array('update' => 'Modifica frazione', 'delete' => 'Elimina frazione');

//include_once BO . 'search.php';

include_once BO . 'table_settings_form.php';
$table = new Table($db, $table_name, $query, $actions);

echo $table->table();
echo $table->paginate();

//include_once BO . 'search_form.php';