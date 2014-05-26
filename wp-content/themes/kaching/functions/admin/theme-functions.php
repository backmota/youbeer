<?php

/* ----------------------------------------------------------------------------------- */
/* Theme Header Output - wp_head() */
/* ----------------------------------------------------------------------------------- */

// This sets up the layouts and styles selected from the options panel

if (!function_exists('adminoptions_wp_head')) {

    function adminoptions_wp_head() {
        $shortname = "tf";
    }

}

add_action('wp_head', 'adminoptions_wp_head');



/* ----------------------------------------------------------------------------------- */
/* Custom CSS Output */
/* ----------------------------------------------------------------------------------- */

function tf_settings_css() {
    $css_array = array();
    $css_link_container = array();
//get all css settings
    $custom_css = get_option('tf_custom_css');
    $dropdown_css = get_option('tf_dropdown');
    $nav_description = get_option('tf_nav_description');
    $google_font = get_option('tf_google_font');
    $custom_google_font = get_option('tf_custom_google_font');
    $blog_image_frame = get_option('tf_blog_image_frame');



//push in css if not empty from setting
    //custom css
    if (!empty($custom_css)) {
        array_push($css_array, $custom_css);
    }


    //navigation css
    if ($dropdown_css != 'false') {
        $drop_css_code = '#menu-main-nav li .drop {display:none !important;}#menu-main-nav li.parent:hover {background:transparent url(' . get_template_directory_uri() . '/images/_global/seperator-main-nav.png) 0 50% no-repeat !important;}#menu-main-nav li {padding: 3px 31px 5px 13px;}#menu-main-nav li.parent, #menu-main-nav li.parent:hover{padding: 3px 31px 5px 13px !important;}*:first-child+html .big-banner #menu-main-nav {margin-bottom:16px;}';
        array_push($css_array, $drop_css_code);
    }

    if ($nav_description != 'false') {
        $nav_css_code = '#menu-main-nav a .navi-description{display:none !important;}#menu-main-nav li.parent:hover{padding-bottom:21px;}#menu-main-nav .drop {top: 41px;}#menu-main-nav {margin-top:12px;}*:first-child+html .big-banner #menu-main-nav {margin-bottom:16px;}#menu-main-nav li {background:none !important;padding-right:20px !important;}';
        array_push($css_array, $nav_css_code);
    }

    if ($dropdown_css != 'false' && $nav_description != 'false') {
        $nav_com_css = '#menu-main-nav li {background:none !important;padding-right:20px !important;}#menu-main-nav li.parent:hover{background: none !important;}#menu-main-nav li.parent, #menu-main-nav li.parent:hover{background:none !important;padding-right:20px !important;}';
        array_push($css_array, $nav_com_css);
    }

    //google font css
    if (($google_font != 'nofont' && $custom_google_font == '')) {
        $google_font_link = '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' . $google_font . '" />' . "\n";
        $google_font_code = '.botwrap, .social_title, #s, .hpslides h2, .hpslides p, header h1, .nav a, #nav li a, #site-footer .widget-title {font-family:\'' . $google_font . '\', Arial, sans-serif;}' . "\n";
        array_push($css_link_container, $google_font_link);
        array_push($css_array, $google_font_code);
    }

    if ($custom_google_font != '') {

        //remove space and add + sign if there is space found in user entered custom font name.
        //the google font name in css link has a plus sign.
        $custom_google_font_name = str_replace(" ", "+", $custom_google_font);

        $google_custom_link = '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' . $custom_google_font_name . '">' . "\n";

        $sanitize = array('+', '-'); //some font name have plus parameter, such as Special+Elite
        // remove the plus and add space to custom font name, if there is a plus between the font name.
        $sanitized_google_font_name = str_replace($sanitize, ' ', $custom_google_font);
        //the google font name in css item, does not have plus sign and needs a space.

        $google_custom_font_code = '.botwrapp {font-family:\'' . $sanitized_google_font_name . '\', Arial, sans-serif;}' . "\n";
        array_push($css_link_container, $google_custom_link);
        array_push($css_array, $google_custom_font_code);
    }


    //blog shadow frame
    if ($blog_image_frame == 'shadow') {
        $nav_com_css = '.post_thumb {background-position: -4px -1470px !important;}';
        array_push($css_array, $nav_com_css);
    }



//construct items and links to print in <head>          
//if not empty css_link_container
    if (!empty($css_link_container)) {
        foreach ($css_link_container as $css_link) {
            echo $css_link . "\n";
        }
    }

//if not empty $css_array, print it out in <head>   
    if (!empty($css_array)) {
        echo"<style type='text/css'>\n";
        foreach ($css_array as $css_item) {
            echo $css_item . "\n";
        }
        echo"</style>\n";
    }
}

//add_action('wp_head', 'tf_settings_css', 90);

?>