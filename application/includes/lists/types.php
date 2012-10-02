<h3>Tipologie di Immobili</h3>

<?php
$types = $db->query("SELECT t._id, t.name, COUNT( p._id ) AS `num`
FROM `types` AS t
LEFT JOIN (
	SELECT _id, type_id, isPublished, isDeleted FROM `properties` WHERE `isPublished`=1 AND `isDeleted`<=0
) AS p 
ON p.type_id = t._id
GROUP BY t._id
ORDER BY t.name
");

$default_page = 0;
$default_contract_id = 0;

?>

<ul class=list>
<?php
if ($types->rowCount() > 0) {
	while ( $type = $types->fetchObject() ) { // URL: type_id / contract_id / id_comune / id_frazione / pr min / pr max / mq min / mq max / cantieri / page
		?>
		<li>
			<a href="<?=ROOT . 'ricerca/'.$type->_id?>"><?=$type->name?> 
			<?php if ( $type->num > 0 ) { ?>
				<span class=number-circle><?=$type->num?></span>
			<?php } ?>
			</a>
		</li>
		<?php
	}
} else {
	echo "Non ci sono tipologie di immobili per il momento.";
}
?>
</ul>