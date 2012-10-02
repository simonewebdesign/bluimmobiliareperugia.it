<div id=middle-column role=main>

<!-- Template name: chi-siamo -->

<?php 

include_once INC . 'h1h2.php';

$men = array(
	array(
		'name' 			=> 'G.',
		'surname' 		=> 'Cipolloni',
		'job'			=> 'Architetto',
		'description'	=> "<p>Laurea conseguita presso la Facoltà di Architettura di Firenze, abilitato alla professione nel novembre 2003. E’ libero professionista dal 2004, lavora prevalentemente su temi di urbanistica, architettura d’interni, progettazione architettonica, recupero edilizio ed architettonico, restauro, architettura del verde e del paesaggio.  Ricopre il ruolo di Progettista, Direttore dei lavori, progettista, assistente e consulente per la sicurezza ai sensi della L. 494/96 e successive integrazioni e modifiche.</p>"//Le collaborazioni : Studio Alecci, Firenze, Studio DNA, Orvieto, Maire Engineering Spa, Roma, Studio Architectonica, Perugia, Arch. Mauro Monella, Perugia.,
		//'curriculum'	=> 'curriculum.pdf'
	),
	array(
		'name' 			=> 'S.',
		'surname' 		=> 'Faluomi',
		'job'			=> 'Geometra',		
		'description'	=> "<p>Diplomato nel 1991, svolge la professione dal 1995, presso lo studio di Magione, operando nel settore della progettazione, della direzione lavori, della contabilità di cantiere. Topografo, utilizza il sistema di rilevazione Geotronix. Attivo nel settore delle costruzioni, tramite partecipazioni dirette in imprese edili nel comprensorio del Trasimeno.</p>"//,
		//'curriculum'	=> 'curriculum.pdf'		
	),
	array(
		'name' 			=> 'F.',
		'surname' 		=> 'Sorbi',
		'job'			=> 'Imprenditore',		
		'description'	=> "<p>Figlio d’arte, proviene da una famiglia di costruttori, ha interrotto gli studi di architettura per esigenze dell’impresa di famiglia, fondata dal padre e dalla zio, quasi mezzo secolo fa, occupandosi di aspetti amm.vi, cantieristica, e soprattutto del ramo comm.le, considerato che l’azienda opera in tutti i settori dell’edilizia, sia privata che pubblica, con particolare riguardo a ristrutturazioni, nuove costruzioni, consolidamenti e ripristini, realizzazioni industriali e commerciali.</p>"
	),
	array(
		'name' 			=> 'F.',
		'surname' 		=> 'Bruni',
		'job'			=> 'Consulente finanziario',	
		'description'	=> "<p>Agente immobiliare dal 2004, inizia ad occuparsi di economia e finanza durante il corso di laurea in Sc.Biologiche. Dopo la laurea, lascia l’attività nel settore biomedico per dedicarsi a finanza e gestione patrimoniale, mobiliare ed immobiliare. Per 8 anni, ha insegnato come docente a contratto presso l’Università degli Studi di Perugia. Svolge la sua attività negli studi di Perugia e P.S.Giovanni, dove ha sede la Blu Immobiliare.</p>"//,
		//'curriculum'	=> 'curriculum.pdf'	
	)	
);

foreach ($men as $man) {
	include INC . 'man.php';
}

?>
	
</div>
