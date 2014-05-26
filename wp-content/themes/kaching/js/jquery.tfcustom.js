// If JavaScript is enabled remove 'no-js' class and give 'js' class
jQuery('html').removeClass('no-js').addClass('js');

// When DOM is fully loaded
jQuery(document).ready(function($) {

	/* load flexslider
	=================================================================================*/
	$('.flexslider').flexslider({
		animation: "fade",
		easing: 'easeInOutExpo',
		slideshow: true,
		slideshowSpeed: 4500,
		animationSpeed: 1600,
		pauseOnAction: true,
		pauseOnHover: false,
		start: function(slider) {
		$(slider).delay(200).fadeTo(600,1);
			$('.home-banner-wrap').removeClass('preloading');
		}
	});

	/* ---------------------------------------------------------------------- */
	/*	Custom Functions
	/* ---------------------------------------------------------------------- */

	// Slide effects for #portfolio-items-filter
	$.fn.slideHorzShow = function( speed, easing, callback ) { this.animate( { marginLeft : 'show', marginRight : 'show', paddingLeft : 'show', paddingRight : 'show', width : 'show' }, speed, easing, callback ); };
	$.fn.slideHorzHide = function( speed, easing, callback ) { this.animate( { marginLeft : 'hide', marginRight : 'hide', paddingLeft : 'hide', paddingRight : 'hide', width : 'hide' }, speed, easing, callback ); };

	// Test whether argument elements are parents of the first matched element
	$.fn.hasParent = function(objs) {
		objs = $(objs);
		var found = false;
		$(this[0]).parents().andSelf().each(function() {
			if ($.inArray(this, objs) != -1) {
				found = true;
				return false;
			}
		});
		return found;
	};

	/* end Custom Functions */

	/* ---------------------------------------------------------------------- */
	/*	Detect touch device
	/* ---------------------------------------------------------------------- */

	(function() {

		if( Modernizr.touch ) {

			$('body').addClass('touch-device');

		}

	})();

	/* end Detect touch device */

	/* ---------------------------------------------------------------------- */
	/*	Main Navigation
	/* ---------------------------------------------------------------------- */
	
	(function() {

		var $mainNav    = $('#main-nav').children('ul'),
			optionsList = '<option value="" selected>Navigate...</option>';
		
		// Regular nav
		$mainNav.on('mouseenter', 'li', function() {
			var $this    = $(this),
				$subMenu = $this.children('ul');
			if( $subMenu.length ) $this.addClass('hover');
			$subMenu.hide().stop(true, true).fadeIn(200);
		}).on('mouseleave', 'li', function() {
			$(this).removeClass('hover').children('ul').stop(true, true).fadeOut(50);
		});

		// Responsive nav
		$mainNav.find('li').each(function() {
			var $this   = $(this),
				$anchor = $this.children('a'),
				depth   = $this.parents('ul').length - 1,
				indent  = '';

			if( depth ) {
				while( depth > 0 ) {
					indent += ' - ';
					depth--;
				}
			}

			optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
		}).end()
		  .after('<select class="responsive-nav">' + optionsList + '</select>');

		$('.responsive-nav').on('change', function() {
			window.location = $(this).val();
		});
		
	})();

	/* end Main Navigation */
	/* ---------------------------------------------------------------------- */
	/*	Showcase Carousel & Post Carousel
	/* ---------------------------------------------------------------------- */

	(function() {

		var $carousel = $('.products-carousel, .post-carousel, .prodthumbs-carousel');

		if( $carousel.length ) {

			var scrollCount;

			function getWindowWidth() {

				if( $(window).width() < 480 ) {
					scrollCount = 1;
				} else if( $(window).width() < 768 ) {
					scrollCount = 2;
				} else if( $(window).width() < 960 ) {
					scrollCount = 2;
				} else {
					scrollCount = 2;
				}

			}

			function initCarousel( carousels ) {

				carousels.each(function() {

					var $this  = $(this);

					$this.jcarousel({
						animation           : 600,
						easing              : 'easeOutCubic',
						buttonPrevHTML: '<span class="prevarrow">‹</span>', 
        				buttonNextHTML: '<span class="nextarrow">›</span>', 
        				wrap: 'circular',
						scroll              : scrollCount,
						itemFirstInCallback : function() {
							onAfterAnimation : resetPosition( $this )
						}
					});

				});

			}

			function adjustCarousel() {

				$carousel.each(function() {

					var $this    = $(this),
						$lis     = $this.children('li')
						newWidth = $lis.length * $lis.first().outerWidth( true ) + 100;

					getWindowWidth();

					// Resize only if width has changed
					if( $this.width() !== newWidth ) {

						$this.css('width', newWidth )
							 .data('resize','true');

						initCarousel( $this );

						$this.jcarousel('scroll', 1);

						var timer = window.setTimeout( function() {
							window.clearTimeout( timer );
							$this.data('resize', null);
						}, 600 );

					}

				});

			}

			function resetPosition( elem, resizeEvent ) {
				if( elem.data('resize') )
					elem.css('left', '0');
			}

			getWindowWidth();

			initCarousel( $carousel );

			// Detect swipe gestures support
			if( Modernizr.touch ) {
				
				function swipeFunc( e, dir ) {
				
					var $carousel = $(e.currentTarget);
					
					if( dir === 'left' ) {
						$carousel.parent('.jcarousel-clip').siblings('.jcarousel-next').trigger('click');
					}
					
					if( dir === 'right' ) {
						$carousel.parent('.jcarousel-clip').siblings('.jcarousel-prev').trigger('click');
					}
					
				}
			
				$carousel.swipe({
					swipeLeft       : swipeFunc,
					swipeRight      : swipeFunc,
					allowPageScroll : 'auto'
				});
				
			}


			// Window resize
			$(window).on('resize', function() {

				var timer = window.setTimeout( function() {
					window.clearTimeout( timer );
					adjustCarousel();
				}, 30 );

			});

		}

	})();

	/* end Showcase Carousel & Post Carousel */

	/* ---------------------------------------------------------------------- */
	/*	Image Gallery Slider
	/* ---------------------------------------------------------------------- */

	(function() {

		var $slider = $('.image-gallery-slider > ul');

		if( $slider.length ) {

			// Run slider when all images are fully loaded
			$(window).load(function() {
				
				$slider.each(function(i) {
					var $this = $(this);

					if( $this.data('mode') === 'disabled' )
						return true;

						$this.css('height', $this.find('li:first img').height() )
							 .after('<div class="image-gallery-slider-nav"> <a class="prev image-gallery-slider-nav-prev-' + i + '">Prev</a> <a class="next image-gallery-slider-nav-next-' + i + '">Next</a> </div>')
							 .cycle({
								 before: function( curr, next, opts ) {
									 var $this = $(this);
									 // set the container's height to that of the current slide
									 $this.parent().stop().animate({ height: $this.height() }, opts.speed);
									 // remove temporary styles, if they exist
									 $('.ss-temp-slider-styles').remove();
								 },
								 containerResize : false,
								 easing          : 'easeInOutExpo',
								 fx              : $this.data('effect'),
								 fit             : true,
								 next            : '.image-gallery-slider-nav-next-' + i,
								 pause           : true,
								 prev            : '.image-gallery-slider-nav-prev-' + i,
								 slideExpr       : 'li',
								 slideResize     : true,
								 speed           : $this.data('speed'),
								 timeout         : $this.data('timeout'),
								 width           : '100%'
							 })
							 .data( 'slideCount', $slider.children('li').length );
					
				});
			
				// Position nav
				var $arrowNav = $('.image-gallery-slider-nav a');
				$arrowNav.css('margin-top', - $arrowNav.height() / 2 );

				// Pause on nav hover
				$('.image-gallery-slider-nav a').on('mouseenter', function() {
					$(this).parent().prev().cycle('pause');
				}).on('mouseleave', function() {
					$(this).parent().prev().cycle('resume');
				})

				// Hide navigation if only a single slide
				if( $slider.data('slideCount') <= 1 )
					$slider.next('.image-gallery-slider-nav').hide();
				
			});

			// Resize
			$(window).on('resize', function() {

				$slider.each(function() {

					var $this = $(this);

					if( $this.data('mode') !== 'disabled' )
						$this.css('height', $this.find('li:visible img').height() );

				});

			});

			// Detect swipe gestures support
			if( Modernizr.touch ) {
				
				function swipeFunc( e, dir ) {
				
					var $slider = $( e.currentTarget );

					// Enable swipes if more than one slide
					if( $slider.data('slideCount') > 1 ) {
											
						$slider.data('dir', '');
						
						if( dir === 'left' ) {
							$slider.cycle('next');
						}
						
						if( dir === 'right' ) {
							$slider.data('dir', 'prev')
							$slider.cycle('prev');
						}

					}
					
				}

				$slider.swipe({
					swipeLeft       : swipeFunc,
					swipeRight      : swipeFunc,
					allowPageScroll : 'auto'
				});

			}

		}

	})();

	/* end Image Gallery Slider */

	/* ---------------------------------------------------------------------- */
	/*	Portfolio Filter
	/* ---------------------------------------------------------------------- */

	(function() {

		var $container = $('#portfolio-items');

		if( $container.length ) {

			var $itemsFilter = $('#portfolio-items-filter'),
				mouseOver;

			// Copy categories to item classes
			$('article', $container).each(function(i) {
				var $this = $(this);
				$this.addClass( $this.attr('data-categories') );
			});

			// Run Isotope when all images are fully loaded
			$(window).on('load', function() {

				$container.isotope({
					itemSelector : 'article',
					layoutMode   : 'fitRows'
				});

			});

			// Filter projects
			$itemsFilter.on('click', 'a', function(e) {
				var $this         = $(this),
					currentOption = $this.attr('data-categories');

				$itemsFilter.find('a').removeClass('active');
				$this.addClass('active');

				if( currentOption ) {
					if( currentOption !== '*' ) currentOption = currentOption.replace(currentOption, '.' + currentOption)
					$container.isotope({ filter : currentOption });
				}

				e.preventDefault();
			});

			$itemsFilter.find('a').first().addClass('active');
			$itemsFilter.find('a').not('.active').hide();

			$itemsFilter.on('mouseenter', function() {
				var $this = $(this);

				clearTimeout( mouseOver );

				// Wait 100ms before animating to prevent unnecessary flickering
				mouseOver = setTimeout( function() {
					if( $(window).width() >= 960 )
						$this.find('li a').stop(true, true).slideHorzShow(300);
				}, 100);
			}).on('mouseleave', function() {
				clearTimeout( mouseOver );

				if( $(window).width() >= 960 )
					$(this).find('li a').not('.active').stop(true, true).slideHorzHide(150);
			});

		}

	})();

	/* end Portfolio Filter */

	/* ---------------------------------------------------------------------- */
	/*	VideoJS
	/* ---------------------------------------------------------------------- */

	(function() {

		var $player = $('.video-js');

		if( $player.length ) {

			function adjustPlayer() {
			
				$player.each(function( i ) {

					var $this        = $(this)
						playerWidth  = $this.parent().width(),
						playerHeight = playerWidth / ( $this.children('.vjs-tech').data('aspect-ratio') || 1.7 );

					if( playerWidth <= 300 ) {
						$this.addClass('vjs-player-width-300');
					} else {
						$this.removeClass('vjs-player-width-300');
					}

					if( playerWidth <= 250 ) {
						$this.addClass('vjs-player-width-250');
					} else {
						$this.removeClass('vjs-player-width-250');
					}

					$this.css({
						'height' : playerHeight,
						'width'  : playerWidth
					})
					.attr('height', playerHeight )
					.attr('width', playerWidth );

				});

			}

			adjustPlayer();

			$(window).on('resize', function() {

				var timer = window.setTimeout( function() {
					window.clearTimeout( timer );
					adjustPlayer();
				}, 30 );

			});

		}

	})();

	/* end VideoJS */

	/* ---------------------------------------------------------------------- */
	/*	FitVids
	/* ---------------------------------------------------------------------- */

	(function() {

		function adjustVideos() {

			var $videos = $('.fluid-width-video-wrapper');

			$videos.each(function() {

				var $this        = $(this)
					playerWidth  = $this.parent().width(),
					playerHeight = playerWidth / $this.data('aspectRatio');

				$this.css({
					'height' : playerHeight,
					'width'  : playerWidth
				})

			});

		}

		$('.container').each(function(){

			var selectors  = [
				"iframe[src^='http://player.vimeo.com']",
				"iframe[src^='http://www.youtube.com']",
				"iframe[src^='http://blip.tv']",
				"iframe[src^='http://www.kickstarter.com']", 
				"object",
				"embed"
			],
				$allVideos = $(this).find(selectors.join(','));

			$allVideos.each(function(){

				var $this = $(this);

				if ( $this.hasClass('vjs-tech') || this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length )
					return;

				var videoHeight = $this.attr('height') || $this.height(),
					videoWidth  = $this.attr('width') || $this.width();

				$this.css({
					'height' : '100%',
					'width'  : '100%'
				}).removeAttr('height').removeAttr('width')
				.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css({
					'height' : videoHeight,
					'width'  : videoWidth
				}).data( 'aspectRatio', videoWidth / videoHeight );

				adjustVideos();

			});

		});

		$(window).on('resize', function() {

			var timer = window.setTimeout( function() {
				window.clearTimeout( timer );
				adjustVideos();
			}, 30 );

		});

	})();

	/* end FitVids */

	/* ---------------------------------------------------------------------- */
	/*	AudioPlayerV1
	/* ---------------------------------------------------------------------- */

	(function() {

		var $player = $('.APV1_wrapper');

		if( $player.length ) {

			function adjustPlayer( resize ){
			
				$player.each(function( i ) {

					var $this            = $(this),
						$lis             = $this.children('li'),
						$progressBar     = $this.children('li.APV1_container'),
						playerWidth      = $this.parent().width(),
						lisWidth         = 0;

					if( !resize )
						$this.prev('audio').hide()

					if( playerWidth <= 300 ) {
						$this.addClass('APV1_player_width_300');
					} else {
						$this.removeClass('APV1_player_width_300');
					}

					if( playerWidth <= 250 ) {
						$this.addClass('APV1_player_width_250');
					} else {
						$this.removeClass('APV1_player_width_250');
					}

					if( playerWidth <= 200 ) {
						$this.addClass('APV1_player_width_200');
					} else {
						$this.removeClass('APV1_player_width_200');
					}

					$lis.each(function() {

						var $li = $(this);
						lisWidth += $li.width()

					});

					$this.width( $this.parent().width() );
					$progressBar.width( playerWidth - ( lisWidth - $progressBar.width() ) );
					
				});

			}

			adjustPlayer();

			$(window).on('resize', function() {

				var timer = window.setTimeout( function() {
					window.clearTimeout( timer );
					adjustPlayer( resize = true );
				}, 30 );

			});

		}

	})();

	/* end AudioPlayerV1 */

	/* ---------------------------------------------------------------------- */
	/*	Accordion Content
	/* ---------------------------------------------------------------------- */

	(function() {

		var $container = $('.acc-container'),
			$trigger   = $('.acc-trigger');

		$container.hide();
		$trigger.first().addClass('active').next().show();

		var fullWidth = $container.outerWidth(true);
		$trigger.css('width', fullWidth);
		$container.css('width', fullWidth);
		
		$trigger.on('click', function(e) {
			if( $(this).next().is(':hidden') ) {
				$trigger.removeClass('active').next().slideUp(300);
				$(this).toggleClass('active').next().slideDown(300);
			}
			e.preventDefault();
		});

		// Resize
		$(window).on('resize', function() {
			fullWidth = $container.outerWidth(true)
			$trigger.css('width', $trigger.parent().width() );
			$container.css('width', $container.parent().width() );
		});

	})();

	/* end Accordion Content */
	
	/* ---------------------------------------------------- */
	/*	Content Tabs
	/* ---------------------------------------------------- */

	(function() {

		var $tabsNav    = $('.tabs-nav'),
			$tabsNavLis = $tabsNav.children('li'),
			$tabContent = $('.tab-content');

		$tabContent.hide();
		$tabsNavLis.first().addClass('active').show();
		$tabContent.first().show();

		$tabsNavLis.on('click', function(e) {
			var $this = $(this);

			$tabsNavLis.removeClass('active');
			$this.addClass('active');
			$tabContent.hide();
			
			$( $this.find('a').attr('href') ).fadeIn();

			e.preventDefault();
		});

	})();

	/* end Content Tabs */

	/* ---------------------------------------------------------------------- */
	/*	Fullwidth Google Maps
	/* ---------------------------------------------------------------------- */

	(function() {

		var $map = $('#map');

		if( $map.length ) {

			$('#map').children('div').css('width', '100%').end()
				 .find('.wpgmappity_container').css('width', '100%');

		}

	})();

	/* end Fullwidth Google Maps */

	 (function() {

		$(".nano").nanoScroller();

	 })();

	/* ----------------------------------------------------- */
	/* Other Scripts */
	/* ----------------------------------------------------- */

});

jQuery(document).ready(function($) {
    jQuery('#site-footer .product-categories').dcAccordion({
		eventType: 'click',
		autoClose: true,
		saveState: true,
		disableLink: true,
		showCount: true,
		speed: 'slow'
});
});

jQuery(window).load(function() {
	jQuery('#slider').nivoSlider({
		directionNavHide: true,
		pauseOnHover: true,
		manualAdvance: true
	});
});

jQuery(window).load(function($) {
		var initheight = jQuery("#hpshop").outerHeight(true);
		var trueinitheight = initheight - 74;
		jQuery('.nano').css('height', trueinitheight);
});

