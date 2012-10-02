<h3>Inserimento nuovi Comuni</h3>

<?php

$query = "SELECT c.`_id` as ID, c.`nome` as comune
FROM
comuni as c
";
//COUNT(p.`_id`) AS `numero_immobili_presenti_in_questo_comune`
//LEFT JOIN properties as p ON p.location_id = 

include_once BO . 'table_settings_form.php';
$table = new Table($db, $table_name, $query);

echo $table->table();
echo $table->paginate();