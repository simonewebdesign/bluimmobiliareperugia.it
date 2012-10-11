<h3>Gestione delle immagini</h3>

<p><b>AGGIORNAMENTO 12/10/2012</b> - Ora non è più necessario caricare la "foto non disponibile" quando non si hanno foto da caricare.</p>

<?php

$query = "SELECT p._id AS `ID_immobile`, p.`reference` AS `codice_immobile`, COUNT( i._id ) AS `numero_immagini`
FROM `properties` p
LEFT JOIN `images` i ON p._id = i.property_id
GROUP BY p._id";
$actions = array('add' => 'Aggiungi nuova immagine', 'view' => 'Visualizza tutte');

include_once BO . 'table_settings_form.php';
$table = new Table($db, $table_name, $query, $actions);

echo $table->table();
echo $table->paginate();