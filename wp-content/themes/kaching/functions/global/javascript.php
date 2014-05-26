<?php

/* ----------------------------------------------------------------------------------- */
/*  Register and load common JS
/*----------------------------------------------------------------------------------- */

function tf_register_js() {
    if (!is_admin()) {
        wp_register_script('tfcustom', get_template_directory_uri() . '/js/jquery.tfcustom.js', 'jquery', '', TRUE);
        wp_register_script('tfhover', get_template_directory_uri() . '/js/tf-hover.js', 'jquery', '', TRUE);
        wp_register_script('tfdeals', get_template_directory_uri() . '/js/tf-deals.js', 'jquery', '', TRUE);
        wp_enqueue_script('mousewheel', TF_JS . '/jquery.mousewheel.min.js', array('jquery'));
        wp_enqueue_script('touchSwipe', TF_JS . '/jquery.touchSwipe.min.js', array('jquery'));
        wp_enqueue_script('tfcustom');
        wp_enqueue_script('tfdeals');
        wp_enqueue_script('easing', TF_JS . '/jquery.easing.1.3.js', 'jquery', TRUE);
        wp_enqueue_script('shortcodes', TF_JS . '/shortcodes.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('superfish', TF_JS . '/superfish.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('tf-nav', TF_JS . '/nav.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('modernizr', TF_JS . '/modernizr.js', 'jquery');
        wp_enqueue_script('flexslider', TF_JS . '/jquery.flexslider.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('nivoslider', TF_JS . '/jquery.nivo.slider.pack.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('jcarousel', TF_JS . '/jquery.jcarousel.js', array('jquery'), '1.0', '1.0', false);
        wp_enqueue_script('nanoscroller', TF_JS . '/jquery.nanoscroller.min.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('overthrow', TF_JS . '/overthrow.min.js', array('jquery'));
        wp_enqueue_script('tf-cookie', TF_JS . '/jquery.cookie.js', array('jquery'), '1.0', TRUE);
        wp_enqueue_script('tf-accordian', TF_JS . '/jquery.dcjqaccordion.2.6.min.js', array('jquery'), 1.0, TRUE);
        wp_enqueue_script('respondjs', TF_JS . '/respond.min.js', array('jquery'), 1.0, false);
        wp_enqueue_script('transit', TF_JS . '/jquery.transit.min.js', array('jquery'), 1.0, TRUE);
        wp_enqueue_script('bathrottle', TF_JS . '/jquery.ba-throttle-debounce.min.js', array('jquery'), 1.0, TRUE);
    }
}

add_action('init', 'tf_register_js');

// load portfolio scripts only on portfolio template
function tf_showcase_js() {
    if ((is_page_template('template_portfolio.php')) || (is_page_template('template_showcase_2col.php')) || (is_page_template('template_showcase_3col.php')) || (is_page_template('template_showcase_4col.php')))
        wp_enqueue_script('isotope', TF_JS . '/jquery.isotope.min.js', array('jquery'), '1.0', TRUE);
    wp_enqueue_script('showcasejs', TF_JS . '/jquery.tfshowcaseotop.js', array('jquery'), '1.0', TRUE);
}

add_action('wp_print_scripts', 'tf_showcase_js');

// load flexloader 
function tf_flexloader() {
    print '<script type="text/javascript" charset="utf-8">
  jQuery(window).load(function() {
    jQuery(\'.flexslider\').flexslider({
        animation: "slide"
    });
  });
</script>';
}

//add_action('wp_head', 'tf_flexloader');

function tf_belatedpng() {

    echo '<!--[if lt IE 7 ]>' . PHP_EOL;
    echo '  <script src="' . get_template_directory_uri() . '/js/dd_belatedpng.js"></script>' . PHP_EOL;
    echo '  <script>DD_belatedPNG.fix(\'img, .png_bg\');</script>' . PHP_EOL;
    echo '<![endif]-->' . PHP_EOL;
}

add_action('wp_footer', 'tf_belatedpng');
function tf_respondjs() {
    echo '<!--[if lt IE 9]>' . PHP_EOL;
    echo '  <script src="' . get_template_directory_uri() . '/js/respond.min.js"></script>' . PHP_EOL;
    echo '<![endif]-->' . PHP_EOL;    
}

//add_action('wp_footer', 'tf_respondjs');
?>