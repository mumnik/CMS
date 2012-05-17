$(document).ready(function() {
	$('form#contactForm').submit(function() {
		$('form#contactForm .error').remove();
		var hasError = false;
		$('.requiredField').each(function() {
			if(jQuery.trim($(this).val()) == '') {
				var labelText = $(this).prev('label').text();
				$(this).parent().append('<span class="error">'+labelText+' required</span>');
				hasError = true;
			} else if($(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim($(this).val()))) {
					var labelText = $(this).prev('label').text();
					$(this).parent().append('<span class="error">invalid '+labelText+'</span>');
					hasError = true;
				}
			}
		});
		if(!hasError) {
			$('form#contactForm ol').slideUp("slow");
			var formInput = $(this).serialize();
			$.post($(this).attr('action'),formInput, function(data){
				$('form#contactForm').slideUp("fast", function() {				   
					$(this).before('<p class="thanks"><strong>Thanks!</strong> Your email was successfully sent.</p>');
				});
			});
		}
		
		return false;
		
	});
});