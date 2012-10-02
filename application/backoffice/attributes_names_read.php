<h3>Inserimento, modifica e cancellazione attributi</h3>

<?php

$query = "SELECT n._id AS ID, n.name AS nome, COUNT( v._id ) AS valori
FROM attributes_names AS n
LEFT JOIN attributes_values AS v ON n._id = v.name_id
GROUP BY n._id";

include_once BO . 'table_settings_form.php';
$actions = array('update' => 'Modifica nome attributo', 
			     'delete' => 'Elimina');
$table = new Table($db, $table_name, $query, $actions);

foreach ( $table->rows as $row ) {
	$row->valori = empty($row->valori) ? '<span style="color:#c99;font-style:italic;">Nessun valore</span>' : $row->valori;
}

echo $table->table();
echo $table->paginate();