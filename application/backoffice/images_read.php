<h3>Gestione delle immagini</h3>

<?php

$query = "SELECT p._id AS `ID_immobile`, p.`reference` as `codice_immobile`, COUNT( i._id ) AS `numero_immagini`
FROM `properties` AS p
LEFT JOIN `images` AS i ON p._id = i.property_id
GROUP BY p._id";
$actions = array('add' => 'Aggiungi nuova immagine',
				 'view' => 'Visualizza tutte');

include_once BO . 'table_settings_form.php';
$table = new Table($db, $table_name, $query, $actions);

echo $table->table();
echo $table->paginate();