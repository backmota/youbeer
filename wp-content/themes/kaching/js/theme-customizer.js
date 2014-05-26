/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).html( to );
		} );
	} );

	//Update site background color...
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
		} );
	} );

	//Update menu link color....
	wp.customize('tf_primary_linkhover_color', function(value) {
		value.bind( function( newval ) {
			$('.nav li.current_page_item a, .nav li.current_menu_item a').css('color', newval );
			$('.nav li a:link').hover (
				function () {
					$(this).css("color", newval);
				});
		});
	});

	//Update main global color....
	wp.customize('tf_mainlinks_color', function(value) {
		value.bind( function( newval ) {
			$('.centertoptitle a:link').hover (
				function () {
					$(this).css("color", newval);
				});
		});
	});

	//Update link color....
	wp.customize('tf_primary_color', function(value) {
		value.bind( function( newval ) {
			$('.flex-next, .flex-prev').hover (
				function () {
					$(this).css("background-color", newval);
				});
		});
	});

	//Update site primary color...
	wp.customize( 'tf_primary_color', function( value ) {
		value.bind( function( newval ) {
			$('header h1 a:link, header h1 a:visited').css('color', newval );
			$('.onsale').css('background', newval );
			$('.sideslidetitle').css('border-bottom-color', newval );
			$('.onsale').css('background', newval );
			$('.flex-control-paging li a.flex-active').css('background', newval );
			$('.hpslides h2').css('background-color', newval );
			$('.hpslide_pricewrap').css('background', newval );
			$('.hp-offer').css('background', newval );
			$('.nav li ul').css('border-top-color', newval );
			$('.nav li ul li a:hover, .nav li ul li.current_page_item a').css('color', newval );
			$('.tf-blog-widget a').css('color', newval );
		} );
	} );

	//Update Top Links color...
	wp.customize( 'tf_toplinks_color', function( value ) {
		value.bind( function( newval ) {
			$('#vtoplinks #slogan, .sub_menu a').css('color', newval );
		} );
	} );

	//Update Button Text color...
	wp.customize( 'tf_buttontext_color', function( value ) {
		value.bind( function( newval ) {
			$('button.button, input.button, input[type="submit"], .widget_shopping_cart .buttons a, a.checkout-button, a.shipping-calculator-button').css('color', newval );
		} );
	} );

	//Update Footerlines..
	wp.customize( 'tf_footerlines_color', function( value ) {
		value.bind( function( newval ) {
			$('#site-footer h4.strap, #site-footer .widget_nav_menu ul li').css('border-bottom-color', newval );
		} );
	} );

	//Update footer background color...
	wp.customize( 'tf_footerbg_color', function( value ) {
		value.bind( function( newval ) {
			$('#site-footer').css('background', newval );
		} );
	} );

	//Update secondary footer background color...
	wp.customize( 'tf_secondfooterbg_color', function( value ) {
		value.bind( function( newval ) {
			$('#site-footer .first-footer-widget .widget_product_categories, #site-footer .first-footer-widget .widget_mailchimpsf_widget, .middlefooter').css('background', newval );
		} );
	} );

	//Update footer text color...
	wp.customize( 'tf_footertext_color', function( value ) {
		value.bind( function( newval ) {
			$('#site-footer, #site-footer .widget-title, #site-footer .widget ul.product_list_widget a, #site-footer .widget ul.product_list_widget li .amount, .tf_tweet_widget ul li > a, #site-footer .tf_tweet_widget ul li > a, .tf_tweet_widget ul li span a, #site-footer .tf_tweet_widget ul li span a, #site-footer .tf_tweet_widget a, #site-footer .widget_product_categories a').css('color', newval );
		} );
	} );

	//Update footer text highlight color...
	wp.customize( 'tf_footerhighlight_color', function( value ) {
		value.bind( function( newval ) {
			$('.middlefooter a, #site-footer h4.strap strong').css('color', newval );
		} );
	} );

	wp.customize( 'tf_hp_text1', function( value ) {
		value.bind( function( to ) {
			$( '.hpwelcome' ).html( to );
		} );
	} );
} )( jQuery );