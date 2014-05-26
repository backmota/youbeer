/*jQuery(document).ready(function() {
	
	jQuery('.deals').find('.dthumbnail').each(function() {
	var desc_height = jQuery(this).find('.dealspiel').outerHeight();
	jQuery(this).find('.dealspiel').css({'display' : 'block', 'bottom' : -(desc_height + 10)});
	
	jQuery(this).hover(function() {
		jQuery(this).find('.dealspiel').stop().animate({bottom: '3px'}, {queue:false, duration:500, easing:'easeInOutExpo'});
	
	}, function() {
		
		jQuery(this).find('.dealspiel').stop().animate({bottom: -(desc_height + 10)}, {queue:false, duration:500, easing:'easeInOutExpo'});
		});
																			  
	});
});*/

jQuery(document).ready(function($) {
	$('#easing_example_1').click(function(event) {
		$(this)
			.animate(
				{ left: 200 }, {
					duration: 'slow',
					easing: 'easeOutBounce'
				})
			.animate(
				{ left: 0 }, {
					duration: 'slow',
					easing: 'easeOutBounce'
				});
	});
});


jQuery(document).ready(function($) {
	
	$('#easing_example_2').click(function(event) {
		$(this)
			.animate(
				{ left: 200 }, {
					duration: 'slow',
					easing: 'easeOutElastic'
				})
			.animate(
				{ left: 0 }, {
					duration: 'slow',
					easing: 'easeOutElastic'
				});
	});
});

jQuery(document).ready(function($) {
	$('#easing_example_3').click(function(event) {
		$(this)
			.animate(
				{ left: 200 }, {
					duration: 'slow',
					easing: 'easeOutBack'
				})
			.animate(
				{ left: 0 }, {
					duration: 'slow',
					easing: 'easeOutBack'
				});
	});
});