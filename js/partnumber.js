// console.log("partnumber js triggered");

$(document).ready(function() {
	$('#addPart form').hide();
	$('tr:even').addClass("zebra");

	$('input[type=submit], input[type=file]').button();
	
	$('#addPart a')
		.button()
		.click(
			function(event) {
				event.preventDefault();
				if ( $('#addPart form').is(':hidden') ){
					$('#addPart form').slideDown();
				}
				else {
					$('#addPart form').slideUp();	
				}
			}
		); // end click

		// $('body').stop().click(
		// 	function (event) {
		// 		if ( !$('#addPart form').is(':hidden') ){
		// 			$('#addPart form').slideUp();	
		// 		}	
		// 	}
		// ); // end click

	$('tr:not(#head)').hover( 
		function() {
			$(this).addClass("zebrahover");
			// var image = $(this).
			// $('#image').attr('src','')
		},
		function() {
			$(this).removeClass("zebrahover");
		}
	); // end hover

	$('tr:not(#head)').click(
		function(event) {
			// var value = $(this.id); // this function doesnt seem to work [object, Object] returned
			var value = $(this).attr('value'); // works gives me the value only
			// var value = $(this).text(); // works give entire row details
			// var value = $(this).html(); // works give html
			// var value = $(this).val(); // works gives me the value only
			console.log("You clicked: " + value);
		}
	); // end click


}); // end ready
