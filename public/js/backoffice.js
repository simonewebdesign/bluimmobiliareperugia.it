$(document).ready( function() {

	$('#table_settings select').on('change', function() {
		$(this).closest('form').submit();
	})

	$('#topbar').css('top','-40px');
	
	function showTopbar() {
		
		$('#topbar').animate({
			top: 0
		}, 2000)
		
		return false;
	}
	
	showTopbar();
})
