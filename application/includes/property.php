
<?php // current container is <div id="content"> ?>

<div class="property-header">
	<h1><?=$property->title?></h1>
	<?php if ( $property->price > 0 ) { ?> 
	<span class="property-price"><?=euro($property->price, 0, 'before') // function euro ( $number, $digits=2, $symbol_before_or_after='after' ?></span>
	<?php } else { ?>
	<span class="property-no-price">Trattativa riservata in ufficio.</span>
	<?php } ?>
</div>

<div class="property-gallery">
<?php include_once 'galleria/themes/classic/gallery.php'; ?>
</div>

<div class="property-description">
<?=$property->description?>
</div>

<dl class="parameters-list clearfix">

	<?php if ($property->surface > 0) { ?>
	<dt>Superficie</dt>
	<dd><?=$property->surface?> m<sup>2</sup></dd>
	<?php } ?>

	<?php if (!empty($property->type)) { ?>
	<dt>Tipologia</dt>
	<dd><?=$property->type?></dd>
	<?php } ?>
	
	<dt>Contratto</dt>
	<dd><?=$property->contract?></dd>
	
	<?php
	// begin custom parameters
	$attributes_query = "
	    SELECT n.name, v.value
		FROM attributes_names as n
		INNER JOIN attributes_values AS v
		ON n._id = v.name_id
		WHERE n._id=:name_id AND v._id=:value_id";
	$attributes_db = $db->prepare($attributes_query);

	$attributes_json = json_decode($property->attributes);
	
//	var_dump($attributes_json);
	
	foreach ($attributes_json as $attribute_name_id => $attribute_value_id) {
	
		//var_dump($attribute_name_id);
		//var_dump($attribute_value_id);
	
		$sql_data = array(
			'name_id' => $attribute_name_id,
			'value_id' => $attribute_value_id
		);
		$attributes_db->execute($sql_data);
		$attribute = $attributes_db->fetchObject();
		
		//var_dump($attribute);
		?>
		<?php if ($attribute) { ?>
		<dt><?=$attribute->name?></dt>
		<dd>
			<?php if ( $attribute_name_id == 3 && strlen($attribute->value) == 1 ) { // $attribute->name is 'Classe Energetica', $attribute->value can be a letter or a long string. ?>
			<img src="<?=ROOT . 'img/icons/energy/' . $attribute->value . '.png'?>" alt="<?=$attribute->value?>">
			<?php } else {
				echo $attribute->value;
			} ?>
		</dd>
		<?php } ?>
	
	<?php 
	} 
	?>
</dl>

<div class="property-creation-date">
<small>
Annuncio pubblicato il <?=$property->creationDate?> &nbsp;&nbsp;&nbsp; Codice di riferimento: <?=$property->reference?>
</small>
</div>