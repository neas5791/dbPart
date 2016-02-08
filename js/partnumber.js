// console.log("partnumber js triggered");

$(document).ready(function() {

	// var fields = new Array('pid', 'descr', 'image', 'drawing_number', 'sup_part_number', 'supplier', 'type');

	// for (var i = 0; i < fields.length; i++) {
	// 	console.log(fields[i])
	// }

	clear(); // clear selection radio mark

	//  basic menu click events 
	$('#toolbox #add_part, #toolbox #add_supplier, #toolbox #add_drawing')
		.click(
			function(event) {
				event.preventDefault();
				console.log(event.target);

				var target = $(this).attr("href");
				// console.log(target_form);
				var arr = target.split('.');
				// console.log(arr[0]);

				var form = '#' + arr[0];

				if ( $(form ).is(':hidden') ) {
					$( form ).slideDown('slow');
					$( form ).addClass('close');
				}
				else {
					$( form ).slideUp('slow');	
					$( form ).removeClass('close');
				}
			}); // end click

	$('#clickme').click(
		function() {
			if ( $('#nav-toolbox form').is(':hidden') ){
					$('#nav-toolbox, #nav-toolbox form').slideDown();
				}
				else {
					$('#nav-toolbox, #nav-toolbox form').slideUp();	
				} // end if-else
		}
	);
	$('#nav-toolbox form').hide(); // hide the div form
	$('#nav-toolbox').hide(); // hide the div
	// $('.edit').hide();
	$('tr:even').addClass("zebra");

	$('input[type=submit], input[type=file]').button();
	
	$('.part #add-button')
		// .button()
		.click(
			function(event) {
				event.preventDefault();
				console.log(event.target);

				$('.drawing_number input :text').prop('disabled', true);//.attr('disabled', 'disabled');
				if ( $('#nav-toolbox form').is(':hidden') ){
					$('#nav-toolbox form').slideDown();
				}
				else {
					$('#nav-toolbox form').slideUp();	
				} // end if-else
			} // end function
		); // end click

	$('#edit-button')
		// .button()
		.click(
			function (event) {
				event.preventDefault();

				if ( $('.edit').is(':hidden') ) {
					$('.edit').show();//("slide", { direction: "left" }, 1000);
					$('.edit').addClass('close');

					$('#table input:radio').each(
						function (evt) {
							$(this).prop('checked', false);
						}
					); // end each
					

					console.log(event.target);
				} // end if
				else {
					$('.edit').hide();//("slide", { direction: "left" }, 1000);
					$('.edit').removeClass('close');
					console.log(event.target);
				} // end else
			} // end function

		); // end click

	$('.drawing #add-button')
		// .button()
		.click(
			function(event) {
				event.preventDefault();
				console.log (event.target);
			}
		); // end click

	$('tr:not(#head)').hover( 
		function() {
			$(this).addClass("zebrahover");
			// var image = $(this).
			// $('#image').attr('src','')
		}, // end function mouse over
		function() {
			$(this).removeClass("zebrahover");
		} // end function mouse out
	); // end hover
	$('td').click( function(event) {
		console.log(event.target);
	}); // end click

	$('.clickable-row #dwg').click( function (evt) {
		var $tr_parent = $(this).parent('tr');

		var value = $tr_parent.attr('value'); // works gives me the value only
		console.log("You clicked: " + value);		
		
		// Jquery: Missing Manual edition 3 Chapter 7 Basic Light-box
		var imgPath, newImage;
		//get path to new image
	  	imgPath = '/img/' + value + '.jpg';
	   	// create HTML for new image, set opacity
	   	// also callback for when image loads
		$img = $('<img src="' + imgPath +'">').css('opacity',0).load(displayImage);
				
		//don't follow link
		evt.preventDefault();
		//don't let event go up page
		evt.stopPropagation();
	}); // end click

	

	// $('.clickable-row').click( function (evt) {
	// 	var value = $(this).attr('data-href'); // works gives me the value only
	// 	console.log("You clicked: " + value);		
		
	// 	// Jquery: Missing Manual edition 3 Chapter 7 Basic Light-box
	// 	var imgPath, newImage;
	// 	//get path to new image
	//   	imgPath = '/img/' + $(this).attr('value') + '.jpg';
	//    	// create HTML for new image, set opacity
	//    	// also callback for when image loads
	// 	$img = $('<img src="' + imgPath +'">').css('opacity',0).load(displayImage);
				
	// 	//don't follow link
	// 	evt.preventDefault();
	// 	//don't let event go up page
	// 	evt.stopPropagation();
	// }); // end click


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

	function clear(){
		
		$('#table input:radio').each(
			function (evt) {
				$(this).prop('checked', false);
			}
		); // end each

		$('.form').hide();
	} // end clear


	function hide_forms() {
		$('close').hide();
	} // end hide_forms

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
