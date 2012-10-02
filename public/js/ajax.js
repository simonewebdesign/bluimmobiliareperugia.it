/* Questa pagina gestisce le richieste AJAX, 
le modifiche visive ed alcune funzionalità aggiuntive, 
tutte relative alle richieste AJAX. */

/* mouse events (in chronological order):
	mousedown
	mouseup
	click
*/

$(document).ready( function() {

	$('a.action').on('click', function() {
		// ajax link has been clicked.
		// first of all, the "delete".
		if ( $(this).hasClass('delete') ) {
		// clicked on a.action delete
			if ( !confirm('Sei sicuro di voler CANCELLARE?') ) { 
				return false
			} else {
				$(this).parent().parent().remove() // delete row only visually
			}
		}
	
		// cleaning up old requests' styles...
		$('#response').removeClass().addClass('clearfix');
	
		$.ajax ({
			// executing ajax request...
			type:	'POST',
			url:	 ROOT + 'ajax.php',
			context: $(this), // document.body,
			data:	'url=' + $(this).attr('href'),
			success: function( data ) {
			
				$('#response')
				.html( data + '<div id="response-close">x</div>' )
				.show('slow')
				// TODO possible enchancement: change bg of selected row
				
				// modifiche funzionali e grafiche true/false
				if ( $(this).hasClass('true') || $(this).hasClass('false') ) {
					
					/* begin modifiche funzionali true/false */
					// clicked on "a.action true/false", with success.
					// recupero l'ultimo carattere dell'attributo href.
					var href = $(this).attr('href')
					var lastchar = href.substr( href.length-1 ) // last char
					
					// se 0 diventa 1, se 1 diventa 0
					if ( lastchar > 0 ) { // lastchar=1 or higher
						lastchar = 0
					} else {
						lastchar = 1
					}
					$(this).attr('href', href.substr(0, href.length-1) + lastchar)
					/* end modifiche funzionali true/false */
					
					/* begin modifiche grafiche true/false */
					if ( $(this).hasClass('true') ) { 
						// clicked on a.action true 
						$(this).removeClass('true')
							   .addClass('false')
							   .text('No')
						$('#response').addClass('negative')
					} else
					if ( $(this).hasClass('false') ) {
						// clicked on a.action false
						$(this).removeClass('false')
							   .addClass('true')
							   .text('Sì')
						$('#response').addClass('positive')
					}
					/* end modifiche grafiche true/false */
					
					/* setTimeout(fadeOut()): non si potrebbe usare perché se l'utente clicca create o altro, #response scompare ugualmente.
                    ma io ho preferito usarlo lo stesso mettendo solo 3 secondi di tempo. 
					setTimeout( function() {
						$('#response').fadeOut()
					}, 3000); // <-- time in milliseconds
					// end modifiche grafiche true/false
					*/
				}
				
			} // end success
		}) // end ajax
		
		/* ... ADD MORE HERE (on a.action click) ... */
		
		
		return false
	}) // end a.action click event
})


/* Using Event Bubbling

Adding scope to a behavior-binding function is often a very elegant solution to the problem of binding event handlers after an AJAX load. We can often avoid the issue entirely, however, by exploiting event bubbling. We can bind the handler not to the elements that are loaded, but to a common ancestor element (in this case, #ajax-response).

Reference: http://docs.jquery.com/Tutorials:AJAX_and_Events

This part binds the events in order to be fired after an AJAX request. 
*/
$('#response').on('click', function(event) {

   if ( $(event.target).is('a.action.add.attribute') ) {

			var nextNumber = parseInt($('p.attributes:last-child').attr('title')) + 1;
			
			if ( typeof(nextNumber) != 'number' || isNaN(nextNumber) || nextNumber == 0 ) {
				nextNumber = 1;
			}
			
   			//begin cloning object
			var newParam = $('p.attributes.mock')
				           .clone()
				           .removeClass('mock')						   
				           .appendTo('#attributes-container');
			
			console.log(nextNumber);

			newParam.attr('title', nextNumber);
			
			newParamName =  'attribute_name_' + nextNumber;
			newParamValue = 'attribute_value_' + nextNumber;
			$('p.attributes:last-child select.name').attr('name', newParamName);
			$('p.attributes:last-child select.value').attr('name', newParamValue);
			 //end cloning object 
			
			// hiding the a.action.add.attribute if parameters >= 20
			if ( nextNumber >= 20 ) {
				$(event.target).hide();
			}	
			
		return false
   }

   if ( $(event.target).is('a.action.add.image') ) {
   
		//alert('add image clicked')
		return false
   }
   
   if ( $(event.target).is('#description') ) {
		// just loading TinyMCE after AJAX...
		tinyMCE.execCommand('mceAddControl', false, 'description');  // description is the textarea's id attr.
		return false;
   }

   if ( $(event.target).is('#response-close') ) {
		$(this).fadeOut()
   }
   
})

$('#response').on('change', function(event) {
	
	if ( $(event.target).is('select.name') ) {
	
		var attribute_name_id = $(event.target).val();
		var ajax_url = ROOT + 'backoffice/attributes_values/get/' + attribute_name_id;
		
		$.ajax ({
			// executing ajax request...
			type:	'POST',
			url:	 ROOT + 'ajax.php',
			context: $(event.target),
			data:	'url=' + ajax_url,
			success: function( data ) {			
				$(this).next().html(data);
			}
		})
	}
	
	if ( $(event.target).is('select#id_comune') ) {
	
		var id_comune = $(event.target).val();
		//var id_proprieta = $('input[name="id"]').val();
		// template_name, table_name, action, id comune, id proprieta
		var ajax_url = ROOT + 'backoffice/properties/get/' + id_comune;
	
		$.ajax ({
			// executing ajax request...
			type:	'POST',
			url:	 ROOT + 'ajax.php',
			context: $(event.target),
			data:	'url=' + ajax_url,
			success: function( data ) {
				$('#placeholder_frazione').html(data);
			}
		})
	}	
	
})


$('#response').on('dblclick', function(event) {
	
	if ( $(event.target).is('div.backoffice-image img') ) {

		if ( !confirm('ATTENZIONE: sei sicuro di voler ELIMINARE l\'immagine?\nQuesta operazione è IRREVERSIBILE!') ) { 
			return false;
		} else {

			var imageName = $(event.target).attr('title');
			var ajax_url = ROOT + 'backoffice/images/delete/' + imageName;
		
			$.ajax ({
				// executing ajax request...
				type:	'POST',
				url:	 ROOT + 'ajax.php',
				context: $(event.target),
				data:	'url=' + ajax_url,
				success: function( data ) {
				
					$('<p style="color:red">' + data + '</p>').appendTo( $(event.target).parent() ) // show response
					$(event.target).remove() // delete row only visually
				}
			});
		}
	}
	
})