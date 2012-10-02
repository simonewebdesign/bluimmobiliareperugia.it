<h3>Gestione tipologie immobili</h3>

<?php

$query = "SELECT t.`_id` AS `ID` ,  t.`name` AS `tipologia`, COUNT( p._id ) AS numero_immobili
FROM `types` AS t
LEFT JOIN properties AS p ON t._id = p.type_id
GROUP BY t._id";

$actions = array('update' => 'Modifica nome tipologia', 'delete' => 'Elimina');

include_once BO . 'table_settings_form.php';

$table = new Table($db, $table_name, $query, $actions);

foreach ($table->row as $row) {
	$row->tipologia = empty($row->tipologia) ? '<span style="color:#c99;font-style:italic;">Nessuna</span>' : $row->tipologia;
}

echo $table->table();
echo $table->paginate();