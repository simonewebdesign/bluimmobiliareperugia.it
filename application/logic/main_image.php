<?php
$main_image_query = "SELECT * FROM images WHERE property_id='{$property->_id}' AND isMain=1 LIMIT 1";
$main_image_db = $db->query($main_image_query);
$main_image = $main_image_db->fetchObject();