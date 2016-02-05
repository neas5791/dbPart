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

	$('.clickable-row').click( function (evt) {
		var value = $(this).attr('data-href'); // works gives me the value only
		console.log("You clicked: " + value);		
		
		// Jquery: Missing Manual edition 3 Chapter 7 Basic Light-box
		var imgPath, newImage;
		//get path to new image
	  	imgPath = '/img/' + $(this).attr('value') + '.jpg';
	   	// create HTML for new image, set opacity
	   	// also callback for when image loads
		$img = $('<img src="' + imgPath +'">').css('opacity',0).load(displayImage);
				
		//don't follow link
		evt.preventDefault();
		//don't let event go up page
		evt.stopPropagation();
	}); // end click


	function displayImage() {
		console.log('running display image');
		// add overlay
		$('<div id="overlay"><div id="photo"></div></div>').prependTo('body');
		// select photo div
		$photoDiv = $('#photo');
		//add to the #photo div
		$photoDiv.append($img);	
		
		// position image
    	$photoDiv.css({marginLeft : ($img.outerWidth()/2) * -1, marginTop : ($img.outerHeight()/2) * -1});
    	//fade in new image
		$img.animate({opacity: 1}, 1000);
	}

	// need to delegate this event doen't work because the 
	// selector doesn't yet exist :(
	$('.photo').click( 
		function(evt) {
			console.log("click photo");
			var $overlay = $('#overlay');
			if (evt.target == $overlay.get(0)) {
					$overlay.remove();
			}
	});

	$('html').on('click',function(evt) {
		var $overlay = $('#overlay');
		if (evt.target == $overlay.get(0)) {
				$overlay.remove();
		}	
	});


}); // end ready


	// 	var imgPath, newImage;
	// 	//get path to new image
	//   	imgPath = $(this).attr('href');
	//    	//create HTML for new image, set opacity
	//    	// also callback for when image loads
	// 	$img = $('<img src="' + imgPath +'">').css('opacity',0).load(displayImage);
		
		
	// 	//don't follow link
	// 	evt.preventDefault();
	// 	//don't let event go up page
	// 	evt.stopPropagation();
	// }); // end click

	// function displayImage() {
	// 	// add overlay
	// 	$('<div id="overlay"><div id="photo"></div></div>').prependTo('body');
	// 	// select photo div
	// 	$photoDiv = $('#photo');
	// 	//add to the #photo div
	// 	$photoDiv.append($img);	
		
	// 	// position image
 //    	$photoDiv.css({marginLeft : ($img.outerWidth()/2) * -1, marginTop : ($img.outerHeight()/2) * -1});
 //    	//fade in new image
	// 	$img.animate({opacity: 1}, 1000);
	// }

	// $('html').on('click',function(evt) {
	// 	var $overlay = $('#overlay');
	// 	if (evt.target == $overlay.get(0)) {
	// 			$overlay.remove();
	// 	}	
	// });


	// 	function(event) {
	// 		// var value = $(this.id); // this function doesnt seem to work [object, Object] returned
	// 		var value = $(this).attr('value'); // works gives me the value only
	// 		// var value = $(this).text(); // works give entire row details
	// 		// var value = $(this).html(); // works give html
	// 		// var value = $(this).val(); // works gives me the value only
	// 		console.log("You clicked: " + value);
	// 	}
	// ); // end click
