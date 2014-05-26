<?php

add_action('init', 'tf_options');

if (!function_exists('tf_options')) {

    function tf_options() {

// VARIABLES
        $themename = "tfbasedetails";
        $shortname = "tf";

// Populate adminoptions option in array for use in theme
        global $tf_options;
        $tf_options = get_option('tf_options');
        $GLOBALS['template_path'] = TF_FRAMEWORK;


//Access the WordPress Categories via an Array
        $tf_categories = array();
        $tf_categories_obj = get_categories('hide_empty=0');
        foreach ($tf_categories_obj as $tf_cat) {
            $tf_categories[$tf_cat->cat_ID] = $tf_cat->cat_name;
        }
        $categories_tmp = array_unshift($tf_categories, "Select a category:");


// //Access the WordPress Pages via an Array
//         $tf_pages = array();
//         $tf_pages_obj = get_pages('sort_column=post_parent,menu_order');
//         foreach ($tf_pages_obj as $tf_page) {
//             $tf_pages[$tf_page->ID] = $tf_page->post_name;
//         }
//         $tf_pages_tmp = array_unshift($tf_pages, "Select the Showcase page:");


// Image Alignment radio box
        $options_thumb_align = array("alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center");


// Image Links to Options
        $options_image_link_to = array("image" => "The Image", "post" => "The Post");


//More Options
        $uploads_arr = wp_upload_dir();
        $all_uploads_path = $uploads_arr['path'];
        $all_uploads = get_option('tf_uploads');
        $other_entries = array("Select a number:", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19");
        $body_repeat = array("no-repeat", "repeat-x", "repeat-y", "repeat");
        $body_pos = array("top left", "top center", "top right", "center left", "center center", "center right", "bottom left", "bottom center", "bottom right");


//Footer Columns Array
        $footer_columns = array("1", "2", "3", "4", "5", "6");

//Logo Type Arrary
        $logo_types = array("image", "text");

//Stylesheets Reader
        // $tf_optstylesheets_path = TF_FILEPATH . '/css/styleoptions/';
        // $tf_optstylesheets = array();

        // if (is_dir($tf_optstylesheets_path)) {
        //     if ($tf_optstylesheets_dir = opendir($tf_optstylesheets_path)) {
        //         while (($tf_optstylesheet_file = readdir($tf_optstylesheets_dir)) !== false) {
        //             if (stristr($tf_optstylesheet_file, ".css") !== false) {
        //                 $tf_optstylesheets[] = $tf_optstylesheet_file;
        //             }
        //         }
        //     }
        // }

//Paths for "type" => "images"
        $url = get_template_directory_uri() . '/functions/admin/images/color-schemes/';
        $footerurl = get_template_directory_uri() . '/functions/admin/images/footer-layouts/';
        $fonturl = get_template_directory_uri() . '/functions/admin/images/fonts/';
        $framesurl = get_template_directory_uri() . '/functions/admin/images/image-frames/';


//Access the WordPress Categories via an Array
        $exclude_categories = array();
        $exclude_categories_obj = get_categories('hide_empty=0');
        foreach ($exclude_categories_obj as $exclude_cat) {
            $exclude_categories[$exclude_cat->cat_ID] = $exclude_cat->cat_name;
        }

        /* ----------------------------------------------------------------------------------- */
        /* Create Site Options Array */
        /* ----------------------------------------------------------------------------------- */
        $options = array();

        $options[] = array("name" => "General Settings",
            "type" => "heading");


        $options[] = array("name" => "Logo Type",
            "desc" => "Do you have an image or text for your logo? You can upload your logo below. You can also enter a text alternative below.",
            "id" => $shortname . "_logotype",
            "std" => "text",
            "type" => "select",
            "options" => $logo_types);


        $options[] = array("name" => "Website Logo",
            "desc" => "Upload a custom logo for your Website.",
            "id" => $shortname . "_sitelogo",
            "std" => "",
            "type" => "upload");

        $options[] = array("name" => "Logo Text",
            "desc" => "If you don't have a logo, this text will be your logo.",
            "id" => $shortname . "_textlogo",
            "std" => "My Text Logo",
            "type" => "text");

        $options[] = array("name" => "Logo Text Tag Line",
            "desc" => "This tagline will appear just beneath your Logo Text",
            "id" => $shortname . "_logotag",
            "std" => "What a brilliant tagline.",
            "type" => "textarea");

         $options[] = array("name" => __("Enable Header Call to Action", 'tfbasedetails'),
            "desc" => __("Do you want to display your company phone number and email in the header?", 'tfbasedetails'),
            "id" => $shortname . "_enable_headercta",
            "std" => "false",
            "type" => "checkbox");

        $options[] = array("name" => "Header Call to Action",
            "desc" => "Enter your store phone number and email address",
            "id" => $shortname . "_headercta",
            "std" => "Call us now on +518-222-45867 or email us on sales@themesforge.com",
            "type" => "textarea");

        $options[] = array("name" => "Blog/News Page Title",
            "desc" => "Enter the Title you wish to display",
            "id" => $shortname . "_blogpagetitle",
            "std" => "Latest News",
            "type" => "text");

        $options[] = array("name" => "Favicon",
            "desc" => "Upload a 16px x 16px image that will represent your website's favicon.",
            "id" => $shortname . "_favicon",
            "std" => "",
            "type" => "upload");

        // $options[] = array("name" => "Showcase Page",
        //     "desc" => "Select your Showcase page from the dropdown list - this will autogenerate the link to your Showcase Page on your homepage if you use the Showcase Widget. NOTE: Permalinks must also be switched on.",
        //     "id" => $shortname . "_scpage",
        //     "std" => "",
        //     "type" => "select",
        //     "options" => $tf_pages);

        $options[] = array("name" => __("Enable Shopping Cart in Header?", 'tfbasedetails'),
            "desc" => __("Do you want to display the WooCommerce Shopping Cart in your header?", 'tfbasedetails'),
            "id" => $shortname . "_enable_wooheadercart",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => __("Enable Footer Promo?", 'tfbasedetails'),
            "desc" => __("Do you want a promotion in your footer?", 'tfbasedetails'),
            "id" => $shortname . "_enable_footer_promo",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => __("Footer Promo Link", 'tfbasedetails'),
            "desc" => __("Enter your Promo link. Make sure to include http://", 'tfbasedetails'),
            "id" => $shortname . "_footer_promo_link",
            "std" => "http://themeforest.net/user/themesforge/portfolio",
            "type" => "text");

        $options[] = array("name" => __("Footer Promo Text", 'tfbasedetails'),
            "desc" => __("Enter your Promo text.", 'tfbasedetails'),
            "id" => $shortname . "_footer_promo_text",
            "std" => "Download this theme now and get your site up and running in minutes!",
            "type" => "text");

        $options[] = array("name" => __("Enable Social Media Links?", 'tfbasedetails'),
            "desc" => __("Do you want to display social media links in your footer?", 'tfbasedetails'),
            "id" => $shortname . "_enable_smicons",
            "std" => "false",
            "type" => "checkbox");

        $options[] = array("name" => __("Facebook Page Link", 'tfbasedetails'),
            "desc" => __("Enter your Facebook page/profile link. Make sure to include http://", 'tfbasedetails'),
            "id" => $shortname . "_fb_link",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Twitter Link", 'tfbasedetails'),
            "desc" => __("Enter your Twitter profile link. Make sure to include http://", 'tfbasedetails'),
            "id" => $shortname . "_tw_link",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Google Plus Page Link", 'tfbasedetails'),
            "desc" => __("Enter your Google Plus page/profile link. Make sure to include http://", 'tfbasedetails'),
            "id" => $shortname . "_gplus_link",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Enable Footer Call to Action?", 'tfbasedetails'),
            "desc" => __("Do you want to display your company phone number and email in the footer?", 'tfbasedetails'),
            "id" => $shortname . "_enable_footercta",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => "Footer Phone Number",
            "desc" => "Enter your store phone number",
            "id" => $shortname . "_footerctaphone",
            "std" => "+518-222-45867",
            "type" => "textarea");

        $options[] = array("name" => "Footer Email",
            "desc" => "Enter your email address",
            "id" => $shortname . "_footerctaemail",
            "std" => "sales@themesforge.com",
            "type" => "textarea");

        $options[] = array("name" => __("Enable payment method icons in footer?", 'tfbasedetails'),
            "desc" => __("Do you want to display accepted payment methods in your footer?", 'tfbasedetails'),
            "id" => $shortname . "_enable_ccicons",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => __("Visa Enabled?", 'tfbasedetails'),
            "desc" => __("Do you want to display Visa as an accepted payment method?", 'tfbasedetails'),
            "id" => $shortname . "_enable_ccvisa",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => __("Mastercard Enabled?", 'tfbasedetails'),
            "desc" => __("Do you want to display Mastercard as an accepted payment method?", 'tfbasedetails'),
            "id" => $shortname . "_enable_ccmc",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => __("Paypal Enabled?", 'tfbasedetails'),
            "desc" => __("Do you want to display Paypal as an accepted payment method?", 'tfbasedetails'),
            "id" => $shortname . "_enable_ccpaypal",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array("name" => __("American Expressed Enabled?", 'tfbasedetails'),
            "desc" => __("Do you want to display Amercian Express as an accepted payment method?", 'tfbasedetails'),
            "id" => $shortname . "_enable_ccamex",
            "std" => "true",
            "type" => "checkbox");

        // $options[] = array("name" => "CSS Style Options",
        //     "type" => "heading");

        // $options[] = array("name" => "Theme CSS Stylesheets",
        //     "desc" => "Select from one of several colour schemes for your theme.",
        //     "id" => $shortname . "_optstylesheet",
        //     "std" => "default.css",
        //     "type" => "select",
        //     "options" => $tf_optstylesheets);

        $shopcolumns = array("3", "4");

        $options[] = array("name" => "WooCommerce Settings",
            "type" => "heading");

        $options[] = array("name" => "Number of Product Columns",
            "desc" => "Select from one of several colour schemes for your theme.",
            "id" => $shortname . "_shopcolumns",
            "std" => "4",
            "type" => "select",
            "options" => $shopcolumns);

        // $options[] = array("name" => "Homepage Settings",
        //     "type" => "heading");

        // $options[] = array("name" => __("Enable Homepage Announcement Box?", 'tfbasedetails'),
        //     "desc" => __("Do you want to enable the homepage announcement box?", 'tfbasedetails'),
        //     "id" => $shortname . "_enable_announcement",
        //     "std" => "false",
        //     "type" => "checkbox");

        // $options[] = array("name" => __("Announcement Details", 'tfbasedetails'),
        //     "desc" => __("The details of the announcement", 'tfbasedetails'),
        //     "id" => $shortname . "_announcement_details",
        //     "std" => "",
        //     "type" => "textarea");

        // $options[] = array("name" => __("Deals Widget Area Title", 'tfbasedetails'),
        //     "desc" => __("This is the text which appears over the 3 main deal widgets on the homepage (e.g. Todays Deals)", 'tfbasedetails'),
        //     "id" => $shortname . "_ctrwidgets_title",
        //     "std" => "",
        //     "type" => "text");

        update_option('tf_template', $options);
        update_option('tf_themename', $themename);
        update_option('tf_shortname', $shortname);
    }

}
?>