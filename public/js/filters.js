function isEmpty(obj) {
    if (typeof obj == 'undefined' || obj === null || obj === '') return true;
    if (typeof obj == 'number' && isNaN(obj)) return true;
    if (obj instanceof Date && isNaN(Number(obj))) return true;
    return false;
}

function filter(contract_id) {

	if (contract_id == null) {
	   contract_id = document.getElementById('current_contract_id').value;
	}

	var type_id 		= isEmpty(document.getElementById('type_id').value) ? 0 : document.getElementById('type_id').value;
	var id_frazione 	= isEmpty(document.getElementById('id_frazione').value) ? 0 : document.getElementById('id_frazione').value;	
	var id_comune 		= isEmpty(document.getElementById('id_comune').value) ? 0 : document.getElementById('id_comune').value;

//	var contract_id 	= document.getElementById('contract').value) ? 0 : document.getElementById('contract_id').value;

	var min_price 		= isEmpty(document.getElementById('min_price').value) ? 0 : document.getElementById('min_price').value;
	var max_price 		= isEmpty(document.getElementById('max_price').value) ? 0 : document.getElementById('max_price').value;
	var prices			= min_price + "_" + max_price;
	
	var min_surface 	= isEmpty(document.getElementById('min_surface').value) ? 0 : document.getElementById('min_surface').value;
	var max_surface 	= isEmpty(document.getElementById('max_surface').value) ? 0 : document.getElementById('max_surface').value;
	var surfaces		= min_surface + "_" + max_surface;
	
	var isUnderConstruction = document.getElementById('isUnderConstruction').checked ? 1 : 0;
	
	var page			= isEmpty(document.getElementById('page').value) ? 1 : document.getElementById('page').value;
	
	// URL DEFINITIVO: root/ricerca/type_id/contract_id/id_frazione/id_comune/prices/surfaces/isUnderConstruction/page
	// es: http://bluimmobiliareperugia/ricerca/appartamento/vendita/ponte-san-giovanni/perugia/123_456/78_90/1/1
	var url = ROOT + 'ricerca/' + 
	type_id			+ '/' +
	contract_id 	+ '/' +
	id_frazione 	+ '/' +
	id_comune 		+ '/' +
	prices 			+ '/' +
	surfaces	 	+ '/' +
	isUnderConstruction	+ '/' +
	page;

	document.location.href = url;
	return false;
}

$(document).ready( function() {

	$('form#filters').on('change', function() {
		filter();
		return false;
	});
	
	$('form#contract button').on('click', function() {		
//		console.log('form#contract button was just clicked!');	
		var contract_id = $(this).val();
//		console.log('selected contract_id from the clicked button = '+contract_id);		
		filter(contract_id);
		return false;
	});
});