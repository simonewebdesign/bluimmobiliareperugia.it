<h3>Gestione degli annunci</h3>

<?php

$query = "SELECT `p`.`_id` AS `ID` , `p`.`reference` AS `riferim` , `t`.`name` AS `tipologia` , `c`.`name` AS `contratto` , `f`.`nome` AS `zona` , `p`.`price` AS `prezzo` , `p`.`surface` AS `superficie` , DATE_FORMAT( `p`.`creationDate` , '%d/%m/%Y %H:%i' ) AS `data_creazione` , `p`.`isPublished` AS `pubblico`
FROM (
(
(
`properties` AS p
LEFT JOIN `types` AS t ON t._id = p.type_id
)
LEFT JOIN `frazioni` AS f ON f._id = p.location_id
)
LEFT JOIN `contracts` AS c ON c._id = p.contract_id
)
WHERE isDeleted=0";

include_once BO . 'search.php';

include_once BO . 'table_settings_form.php';
$actions = array('update' => 'Mod.', 'delete' => 'Canc.');
$table = new Table($db, $table_name, $query, $actions);

foreach ($table->rows as $row) {
	$row->tipologia = empty($row->tipologia) ? '<span style="color:#c99;font-style:italic;">Nessuna</span>' : $row->tipologia;
	$row->zona = empty($row->zona) ? '<span style="color:#c99;font-style:italic;">Nessuna</span>' : $row->zona;
	$row->prezzo = $row->prezzo > 0 ? euro($row->prezzo) : '<i>Tr. riserv.</i>';
	$row->superficie	= $row->superficie . ' <small>m<sup>2</sup></small>';
	$row->pubblico = publish($table_name, $row->pubblico, $row->ID);
}

echo $table->table();
echo $table->paginate();

include_once BO . 'search_form.php';