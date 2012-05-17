$(function () {

	$('#slideshowHolder').hide();
	var slidenos = $('#slideshowHolder').length;
	
});

var i;

$(window).bind("load", function() {

	var slidenos = $('#slideshowHolder').length;

		$('#slideshowHolder:hidden').fadeIn(800);

		$('#slideshowHolder').jqFancyTransitions({
			effect: 'wave',
			'navigation' : true,
			'links' : true,
			strips: 20,
			stripDelay: 60,
			direction: 'random',
			width: 940, 
			height: 474 
		});


});