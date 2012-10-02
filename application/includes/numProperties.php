<?php

$count_db = $db->query("SELECT COUNT(_id) AS numProperties FROM properties");
$count = $count_db->fetchObject();

?>

<h3>Lo sapevi?</h3>

<p><b>Blu Immobiliare Perugia</b>, agenzia di servizi immobiliari molto nota nel territorio umbro, vanta oltre <b>54 mila <!--<?=$count->numProperties?> --></b> pubblicazioni di annunci di immobili, in particolare nelle zone di <b>Perugia</b> e <b>Trasimeno</b>.</p>