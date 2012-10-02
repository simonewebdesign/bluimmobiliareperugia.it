<?php

/* Da qui passano tutte le richieste ajax. 
Questa pagina serve solamente ad includere la pagina appropriata a seconda di quale richiesta ajax è stata effettuata.
Ci penserà la pagina inclusa a gestire la richiesta, pertanto non c'è bisogno di usare db o altro: il bootstrap qui non è necessario.
*/

// get url from $_POST
$href = isset($_POST['url']) ? $_POST['url'] : false;

if ( $href ) {


	include '../config/paths.php';	
	/* removing ROOT from $href, just to avoid issues while in environments different than localhost. */
	$replacement = '';
	$start = 0;
	$length = strlen(ROOT);
	$href = substr_replace( $href, $replacement, $start, $length);

	/* debug *
	echo "the url from _POST <small>(sanitized)</small>: "; var_dump($href);
	//*/
	$params = explode('/', $href);
	/* debug *
	echo "params: "; var_dump($params);
	//*/
	list($template_name, $table_name, $action) = $params;
	
	$id = isset($params[3]) ? $params[3] : 0;
	/* debug *
	echo "template_name:"; var_dump($template_name);
	echo "table_name:";	   var_dump($table_name);
	echo "action:"; 	   var_dump($action);
	echo "id:";		  	   var_dump($id);
	//*/

	/* more simple debug *
	echo "template_name: $template_name";
	echo "table_name: $table_name";
	echo "action: $action";
	echo "id: $id";
	//*/

	if ( $template_name ) {
		if ( $table_name ) {
			if ( $action ) {
				include "../application/" . $template_name . "/" . $table_name . "_" . $action . ".php";
			} else {
				include "../application/" . $template_name . "/" . $table_name . ".php";
			}
		}
	}
	
}