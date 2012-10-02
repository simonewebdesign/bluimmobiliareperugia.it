<?php
try {
	$db = new PDO ( "mysql:host=" . HOSTNAME . ";dbname=" . DBNAME, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}