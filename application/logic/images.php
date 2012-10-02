<?php
$images_query = "SELECT * FROM images WHERE property_id='{$property->_id}'";
$images = $db->query($images_query);

//var_dump($images->rowCount());