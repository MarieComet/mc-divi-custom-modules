jQuery(document).ready(function($){

	// Get an array of all element heights
	var elementHeights = $('.et_pb_flipbox p').map(function() {
		return $(this).outerHeight();
	}).get();

	// Math.max takes a variable number of arguments
	// `apply` is equivalent to passing each height as an argument
	var maxHeight = Math.max.apply(null, elementHeights);

	// Set each height to the max height
	$('.et_pb_flipbox').height(maxHeight);
});