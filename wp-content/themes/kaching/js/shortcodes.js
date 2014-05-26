jQuery(document).ready(function($){

	/* Accordion */
	var allPanels = $('.accordion > .inner').hide();
    
  	$('.accordion > .title > a').click(function() {
      $this = $(this);
      $target =  $this.parent().next();

      if(!$target.hasClass('active')){
         allPanels.slideUp(400, 'easeOutCirc');
         $target.slideDown(400, 'easeOutCirc');
         $this.parent().parent().find('.title').removeClass('active');
         $this.parent().addClass('active');
      }
      return false;
  	});
  	
  	$('.accordion > .inner').first().show();
  	$('.accordion .title').first().addClass('active');
  	
  	/* ----------------------------------------------------- */
  	/* Toggle */
	$(".toggle .title").toggle(function(){
		$(this).addClass("active").closest('.toggle').find('.inner').slideDown(400, 'easeOutCirc');
		}, function () {
		$(this).removeClass("active").closest('.toggle').find('.inner').slideUp(400, 'easeOutCirc');
	});
	
	/* ----------------------------------------------------- */
	/* Tabs */
	var tabContainers = $('div.tabs > div');
	tabContainers.hide().filter(':first').show();
			
	$('div.tabs ul.tabNavigation a').click(function () {
		tabContainers.hide();
		tabContainers.filter(this.hash).show();
		$('div.tabs ul.tabNavigation a').removeClass('active');
		$(this).addClass('active');
		return false;
	}).filter(':first').click();
	
	/* ----------------------------------------------------- */
  	/* Alert */
	$(".alert-message a").click(function(){
		$(this).parent().slideUp();
		return false;
	});
	
});