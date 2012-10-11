<?php
$images_db = $db->prepare("SELECT * FROM images WHERE property_id=?");
$images_db->execute(array($property->_id));
$images = $images_db;