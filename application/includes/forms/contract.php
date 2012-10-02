<?php 

$current_contract_id = isset($get[2]) ? $get[2] : 0;

$contracts = array(
	//0 => 'Tutti gli annunci',
	1 => 'Vendite',
	2 => 'Affitti',
	3 => 'Investimenti'
);

?>

<form id=contract>

<?php foreach ( $contracts as $contract_id => $contract_name ) { ?>
	<h4>
		<button value=<?=$contract_id?><?=$contract_id == $current_contract_id ? ' class=current-contract' : ''?>>
			<?=$contract_name?>
		</button>
	</h4>	
<?php } ?>

	<input id=current_contract_id type=hidden value=<?=isset($get[2]) ? $get[2] : 0?>>
	
</form>