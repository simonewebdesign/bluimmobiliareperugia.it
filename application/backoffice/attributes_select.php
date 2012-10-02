<?php

// needs $parameter_names

echo '<p class="attributes clearfix" title='.$i.'>';
	//if ( $i > 2 ) { echo ' last'; }
	echo "<select name=attribute_name_$i class=name>";
		echo "<option value=0>Seleziona attributo...</option>";
	foreach ( $attributes_names as $attribute_name ) {
	
		echo "<option value={$attribute_name['_id']}";
		if ( isset($name) && $name == $attribute_name['_id'] ) {
			$current_name_id = $name;
			echo " selected";
		}
		echo ">{$attribute_name['name']}</option>";
		
	}
	echo "</select>";

	echo "<select name=attribute_value_$i class=value>";
	
		$attributes_values_query = "
			SELECT `_id`, `value`
			FROM `attributes_values`
			WHERE `name_id` = {$current_name_id}
			ORDER BY `value`
			LIMIT 50";
		$attributes_values_db = $db->query($attributes_values_query);
	
		while ( $attribute_value = $attributes_values_db->fetchObject() ) {
			echo "<option value={$attribute_value->_id}";
			echo $value == $attribute_value->_id ? ' selected' : '';
			echo ">{$attribute_value->value}</option>";
		}

	echo "</select>";

echo '</p>';