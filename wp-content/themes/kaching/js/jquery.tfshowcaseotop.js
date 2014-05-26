/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/
 
jQuery(document).ready(function() {
	
	jQuery('body').addClass('jsenabled');
	
	var slideDuration = 600;
	
/*-----------------------------------------------------------------------------------*/
/*	Isotope call for the Showcase/Portfolio template
/*-----------------------------------------------------------------------------------*/

	if( jQuery().isotope ) {
	    
	    jQuery(function() {

            var container = jQuery('.isotope'),
                optionFilter = jQuery('#sort-by'),
                optionFilterLinks = optionFilter.find('a');
            
            optionFilterLinks.attr('href', '#');
            
            optionFilterLinks.click(function(){
                var selector = jQuery(this).attr('data-filter');
                container.isotope({ 
                    filter : '.' + selector, 
                    itemSelector : '.isotope-item',
                    layoutMode : 'fitRows',
                    animationEngine : 'best-available'
                });
                
                // Highlight the correct filter
                optionFilterLinks.removeClass('active');
                jQuery(this).addClass('active');
                return false;
            });
            
	    });
    
	}
	
	
});