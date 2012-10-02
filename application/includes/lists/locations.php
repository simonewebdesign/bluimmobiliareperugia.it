<h3>Annunci dai Comuni</h3>

<?php
$comuni = $db->query("SELECT c._id, c.nome, COUNT( p._id ) AS `num`
FROM ((
comuni AS c
LEFT JOIN frazioni AS f ON c._id = f.id_comune
)
LEFT JOIN (SELECT _id, location_id, isPublished, isDeleted FROM `properties` WHERE `isPublished` =1 AND `isDeleted` <=0) AS p ON p.location_id = f._id
)
GROUP BY c._id
ORDER BY c.nome");

$default_type_id = 0;
$default_contract_id = 0;
$default_location_id = 0;
?>

<ul class=list>
<?php
if ( $comuni->rowCount() > 0 ) {
	while ( $comune = $comuni->fetchObject() ) { // URL:  type_id / contract_id / id_comune / id_frazione / pr min / pr max / mq min / mq max / cantieri / page /
		?>
		<li> 
			<a href="<?=ROOT . 'ricerca/'.$default_type_id.'/'.$default_contract_id.'/'.$default_location_id.'/'.$comune->_id?>"><?=$comune->nome?> 
			<?php if ( $comune->num > 0 ) { ?>
				<span class=number-circle><?=$comune->num?></span>
			<?php } ?>
			</a>
		</li>
		<?php
	}
} else {
	echo "Non ci sono comuni al momento.";
}
?>
</ul>

