<form id=message-form method=POST class=clearfix>
	
	<fieldset><legend>Invia una richiesta all'agenzia</legend>
	
		<div>
			<p class=clearfix>
				<label for=name>Nome <span class=required-asterisk title="Questo campo è obbligatorio.">*</span></label>
				<input id=name name=name type=text size=20 maxlength=50 required>
			</p>
			<p class=clearfix>
				<label for=email>Email <span class=required-asterisk title="Questo campo è obbligatorio.">*</span></label>
				<input id=email name=email type=email size=20 maxlength=100 required>
			</p>
			<p class=clearfix>
				<label for=tel>Telefono</label>
				<input id=tel name=tel type=text size=20 maxlength=30>
			</p>
		</div>
		
		<div>
			<p class=clearfix>
				<label for=message>Messaggio <span class=required-asterisk title="Questo campo è obbligatorio.">*</span></label>
				<textarea id=message name=message rows=5 cols=20 required placeholder="Scrivi qui le tue richieste per ricevere informazioni più dettagliate."></textarea>
			</p>
			
			<input type="submit" name="submit" value="Invia Richiesta">
		</div>
		
		<?php
		if (isset($_POST['submit'])) {
			$header = "From: {$_POST['name']} <{$_POST['email']}>";
			$subject = "[RIF: {$property->reference}] Richiesta da www.bluimmobiliareperugia.it";
			$message = "{$_POST['message']}\n\nTel: {$_POST['tel']}";
			/* mail(to,subject,message,additional_headers,additional_parameters) */
			if ( !mail(MAIL_TO, $subject, $message, $header) ) {
				echo "<p style='color:#800'>Siamo spiacenti, a causa di un errore non abbiamo potuto inoltrare la sua richiesta. Si prega di riprovare più tardi.</p>";
			} else {
				echo "<p style='color:green'>La sua richiesta è stata recapitata correttamente. Le risponderemo a breve.</p>";
			}
		}
		?>
		
	</fieldset>
		
	<p class=disclaimer>La informiamo che il suo indirizzo email ed eventualmente i suoi recapiti saranno utilizzati esclusivamente per rispondere alla sua richiesta, e verranno trattati secondo i termini descritti dalla nostra <a href="<?=ROOT?>privacy">Informativa sulla privacy</a>.</p>	
	
</form>