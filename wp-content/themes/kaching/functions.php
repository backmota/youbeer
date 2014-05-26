<?php
/**
 * tfbasedetails functions and definitions. Tread very carefully in here and don't upset the wp functions monkeys as they have wings like those ones in the Wizard of Oz and will track you down and probably bite you - they like to be left alone.
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, boilerplate_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.2
 */

/* SOME GLOBAL PATHS TO MAKE OTHER STUFF EASIER */

define('TF_FILEPATH', get_template_directory());
define('TF_FUNCTIONS', get_template_directory() . '/functions');
define('TF_NAVFUNCTIONS', get_template_directory() . '/functions/nav');
define('TF_ADMINOPTIONS', get_template_directory() . '/functions/admin');
define('TF_EXTENDED', get_template_directory() . '/functions/extended');
define('TF_FRAMEWORK', get_template_directory_uri() . '/functions');
define('TF_CSS', get_template_directory_uri() . '/css');
define('TF_HOME', get_template_directory_uri());
define('TF_JS', get_template_directory_uri() . '/js');
define('TF_GLOBAL', get_template_directory() . '/functions/global');
define('TF_WIDGETS', get_template_directory() . '/functions/global/widgets');
define('TF_POSTTYPES', get_template_directory() . '/functions/global/posttypes');
define('TF_CUSTOMFIELDS', get_template_directory() . '/functions/global/customfields');

/* LOAD CSS */

function load_tfstyles() {
wp_register_style( 'tf-hbp', get_template_directory_uri() . '/css/boilerplate.css' );
wp_register_style( 'tf-skeleton', get_template_directory_uri() . '/css/skeleton.css' );
wp_register_style( 'tf-nanoscroller', get_template_directory_uri() . '/css/nanoscroller.css' );
wp_register_style( 'tf-shortcodes', get_template_directory_uri() . '/css/shortcodes.css' );
wp_register_style( 'tf-layout', get_template_directory_uri() . '/css/layout.css' );
wp_register_style( 'tf-flexslider', get_template_directory_uri() . '/css/flexslider.css' );
wp_register_style( 'tf-nivo', get_template_directory_uri() . '/css/nivo-slider.css' );
wp_register_style( 'tf-nav', get_template_directory_uri() . '/css/nav.css' );
wp_register_style( 'tf-woocommercecss', get_template_directory_uri() . '/woocommerce/css/style.css' );
wp_register_style( 'tf-fontawesome', get_template_directory_uri() . '/css/font-awesome.css' );
wp_register_style( 'tf-customcss', get_template_directory_uri() . '/css/custom.css' );    

wp_enqueue_style( 'tf-hbp' );
wp_enqueue_style( 'tf-skeleton' );
wp_enqueue_style( 'tf-nanoscroller' );
wp_enqueue_style( 'tf-shortcodes' );
wp_enqueue_style( 'tf-layout' );
wp_enqueue_style( 'tf-flexslider' );
wp_enqueue_style( 'tf-nivo' );
wp_enqueue_style( 'tf-nav' );
wp_enqueue_style( 'tf-woocommercecss' );
wp_enqueue_style( 'tf-fontawesome' );
wp_enqueue_style( 'tf-customcss' );   
}

add_action('wp_enqueue_scripts', 'load_tfstyles');


/* LOAD GLOBALS */

require_once(TF_GLOBAL . '/javascript.php');
require_once(TF_GLOBAL . '/customizer_w.php');
require_once(TF_NAVFUNCTIONS . '/navfunctions.php');
require_once(TF_NAVFUNCTIONS . '/dropdown-menus.php');
require_once(TF_NAVFUNCTIONS . '/blog-pagination.php');

/* LOAD ADMIN */
require_once(TF_ADMINOPTIONS . '/admin-functions.php');
require_once(TF_ADMINOPTIONS . '/admin-interface.php');
require_once(TF_ADMINOPTIONS . '/theme-options.php');
require_once(TF_ADMINOPTIONS . '/theme-functions.php');

/* LOAD EXTENDED FUNCTIONALITY */

require_once(TF_EXTENDED . '/get-the-image.php');
require_once(TF_EXTENDED . '/shortcodes.php');

add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');
add_filter('textarea', 'do_shortcode');

/* LOAD WIDGETS */

require_once(TF_WIDGETS . '/featured-content-widget.php');
require_once(TF_WIDGETS . '/featured-deal-widget.php');
require_once(TF_WIDGETS . '/hp-blog-widget.php');
require_once(TF_WIDGETS . '/tf-flickr-widget.php');
require_once(TF_WIDGETS . '/tf-featured-products-jcarousel-icaro.php');
require_once(TF_WIDGETS . '/tf-side-widget-recent_products.php');
require_once(TF_WIDGETS . '/tf-recent-products-jcarousel-icaro.php');
require_once(TF_WIDGETS . '/tf-store-promo.php');
require_once(TF_WIDGETS . '/tf-latest-testimonials.php');


/* LOAD CUSTOM POST TYPES */

require_once(TF_POSTTYPES . '/posttypes.php');

/* Responsive Images */

add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);

function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

/* WooCommerce */

/* ----------------------------------------------------------------------------------- */
/* Start WooThemes Functions - Please refrain from editing this section */
/* ----------------------------------------------------------------------------------- */

// Register Support

add_theme_support( 'woocommerce' );


// Set path to WooFramework and theme specific functions
$woocommerce_path = get_template_directory() . '/woocommerce/';

// WooCommerce
require_once ($woocommerce_path . 'config.php' );    //woocommerce shop plugin
require_once ($woocommerce_path . 'woocommerce-init.php' );                     // WooCommerce Init
require_once ($woocommerce_path . 'woocommerce-layout.php' );                   // WooCommerce Layout
require_once ($woocommerce_path . 'woocommerce-functions.php' );                // WooCommerce Functions
require_once ($woocommerce_path . 'theme-install.php' );                        // Theme installation

/**
 * Helper function for @get_the_content_limit()
 *
 * */
function tf_truncate_phrase($phrase, $max_characters) {

    $phrase = trim($phrase);

    if (strlen($phrase) > $max_characters) {

        // Truncate $phrase to $max_characters + 1
        $phrase = substr($phrase, 0, $max_characters + 1);

        // Truncate to the last space in the truncated string.
        $phrase = trim(substr($phrase, 0, strrpos($phrase, ' ')));
    }

    return $phrase;
}

/**
 * This function strips out tags and shortcodes,
 * limits the output to $max_char characters,
 * and appends an ellipses and more link to the end.
 *
 * */
function get_the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0) {

    $content = get_the_content('', $stripteaser);

    // Strip tags and shortcodes
    $content = strip_tags(strip_shortcodes($content), apply_filters('get_the_content_limit_allowedtags', '<script>,<style>'));

    // Inline styles/scripts
    $content = trim(preg_replace('#<(s(cript|tyle)).*?</\1>#si', '', $content));

    // Truncate $content to $max_char
    $content = tf_truncate_phrase($content, $max_char);

    // More Link?
    if ($more_link_text) {
        $link = apply_filters('get_the_content_more_link', '&hellip; <a href="' . get_permalink() . '" class="more-link">' . $more_link_text . '</a>', $more_link_text);

        $output = sprintf('<p>%s %s</p>', $content, $link);
    } else {
        $output = sprintf('<p>%s</p>', $content);
    }

    return apply_filters('get_the_content_limit', $output, $content, $link, $max_char);
}

function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0) {

    $content = get_the_content_limit($max_char, $more_link_text, $stripteaser);
    echo apply_filters('the_content_limit', $content);
}

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if (!isset($content_width))
    $content_width = 640;

/** Tell WordPress to run tfbasedetails_setup() when the 'after_setup_theme' hook is run. */
add_action('after_setup_theme', 'tfbasedetails_setup');

if (!function_exists('tfbasedetails_setup')):

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     */
    function tfbasedetails_setup() {

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain('tfbasedetails', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );

        /* REGISTER MAIN MENU */
        register_nav_menu('Main Navigation', 'Main Navigation');

        /* REGISTER FOOTER MENU */
        register_nav_menu('Footer Navigation', 'Footer Navigation');

        // Enable Post Formats for WP 3.1+
        //add_theme_support('post-formats', array('aside', 'gallery', 'image', 'link'));
    }

endif;

/* LOAD METABOX FRAMEWORK */

// Re-define meta box path and URL
//define('RWMB_URL', trailingslashit(get_stylesheet_directory_uri() . '/meta-box'));
define('RWMB_URL', trailingslashit(get_template_directory_uri() . '/meta-box'));
define('RWMB_DIR', trailingslashit(get_template_directory() . '/meta-box'));

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

// Include the meta box definition (This is the file where you define meta boxes, see `demo/demo.php`)
require_once get_template_directory() . '/meta-box.php';

function tf_wp_title() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active('wordpress-seo/wp-seo.php')) {
        wp_title('');
    }
    else {
        wp_title('|', true, 'right'); bloginfo('name');
    }
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function tfbasedetails_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'tfbasedetails_page_menu_args');

/**
 * Sets the post excerpt length to 20 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function tfbasedetails_excerpt_length($length) {
    return 20;
}

add_filter('excerpt_length', 'tfbasedetails_excerpt_length');

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function tfbasedetails_continue_reading_link() {
    //gones for now!
    return '';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and boilerplate_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function tfbasedetails_auto_excerpt_more($more) {
    return ' &hellip;' . tfbasedetails_continue_reading_link();
}

add_filter('excerpt_more', 'tfbasedetails_auto_excerpt_more');

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function tfbasedetails_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= tfbasedetails_continue_reading_link();
    }
    return $output;
}

add_filter('get_the_excerpt', 'tfbasedetails_custom_excerpt_more');

function tf_cusexcerpt($excerpt = '', $excerpt_length = 10, $readmore = "Read more", $tags = '<a>') {
    global $post;
    $string_check = explode(' ', $excerpt);

    if (count($string_check, COUNT_RECURSIVE) > $excerpt_length) {
        $new_excerpt_words = explode(' ', $excerpt, $excerpt_length + 1);
        array_pop($new_excerpt_words);
        $excerpt_text = implode(' ', $new_excerpt_words);
        $temp_content = strip_tags($excerpt_text, $tags);
        $short_content = preg_replace('`\[[^\]]*\]`', '', $temp_content);
        $short_content .= ' ...';
        return $short_content;
    } else {
        return $excerpt;
    }
}

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function tfbasedetails_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}

add_filter('gallery_style', 'tfbasedetails_remove_gallery_css');

if (!function_exists('tfbasedetails_comment')) :

    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own twentyeleven_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @since Twenty Eleven 1.0
     */
    function tfbasedetails_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'tfbasedetails'), ' '); ?></p>
                    <?php
                    break;
                default :
                    ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment">
                        <footer class="comment-meta">
                            <div class="comment-author vcard">
                                <div class="commentavatar">
                                    <?php
                                    $avatar_size = 39;

                                    echo get_avatar($comment, $avatar_size);
                                    ?>
                                </div>
                                <div class="commentmadeat">
                                    <?php
                                    printf(__('%1$s on %2$s%3$s at %4$s%5$s <span class="says">said:</span>', 'tfbasedetails'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link()), '<a href="' . esc_url(get_comment_link($comment->comment_ID)) . '"><time pubdate datetime="' . get_comment_time('c') . '">', get_comment_date(), get_comment_time(), '</time></a>'
                                    );
                                    ?>

                                    <?php edit_comment_link(__('[Edit]', 'tfbasedetails'), ' '); ?>
                                </div>
                            </div><!-- .comment-author .vcard -->

                            <?php if ($comment->comment_approved == '0') : ?>
                                <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'tfbasedetails'); ?></em>
                                <br />
                            <?php endif; ?>

                        </footer>
                        <div class="clearboth"></div>

                        <div class="comment-content"><?php comment_text(); ?></div>

                        <div class="reply">
                            <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply &darr;', 'tfbasedetails'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                        </div><!-- .reply -->
                    </article><!-- #comment-## -->

                    <?php
                    break;
            endswitch;
        }

    endif; // ends check for tfbasedetails_comment()

    /**
     * Register widgetized areas.
     */
    function tfbasedetails_widgets_init() {

        // Main Primary Sidebar.
        register_sidebar(array(
            'name' => __('Primary Widget Area', 'tfbasedetails'),
            'id' => 'primary-widget-area',
            'description' => __('The primary widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Located in the Header - mainly for search box.
        register_sidebar(array(
            'name' => __('Header Widget Area', 'tfbasedetails'),
            'id' => 'header-widget-area',
            'description' => __('The header widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // A sidebar just for WooCommerce.
        register_sidebar(array(
            'name' => __('Shop Sidebar Widget Area', 'tfbasedetails'),
            'id' => 'shop-widget-area',
            'description' => __('The shop sidebar widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // A sidebar just below the Homepage Slider
        register_sidebar(array(
            'name' => __('Homepage Top Widget Area', 'tfbasedetails'),
            'id' => 'homepage-top-widget-area',
            'description' => __('The content will be displayed just under your homepage slider and before the homepage middle widgets.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Middle Widget Area 1.
        register_sidebar(array(
            'name' => __('Homepage Middle Widget Area 1', 'tfbasedetails'),
            'id' => 'first-center-middle-widget-area',
            'description' => __('The content will be displayed in the first center widget middle area.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Middle Widget Area 2.       
        register_sidebar(array(
            'name' => __('Homepage Middle Widget Area 2', 'tfbasedetails'),
            'id' => 'second-center-middle-widget-area',
            'description' => __('The content will be displayed in the second center widget middle area.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Middle Widget Area 3.       
        register_sidebar(array(
            'name' => __('Homepage Middle Widget Area 3', 'tfbasedetails'),
            'id' => 'third-center-middle-widget-area',
            'description' => __('The content will be displayed in the third center widget middle area.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Bottom Widget Area 1
        register_sidebar(array(
            'name' => __('Homepage Bottom Widget Area 1', 'tfbasedetails'),
            'id' => 'first-center-bottom-widget-area',
            'description' => __('The content will be displayed in the first center widget bottom area', 'tfbasedetails'),
            /*'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',*/
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Bottom Widget Area 2.
        register_sidebar(array(
            'name' => __('Homepage Bottom Widget Area 2', 'tfbasedetails'),
            'id' => 'second-center-bottom-widget-area',
            'description' => __('The content will be displayed in the second center widget bottom area.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        // Above Footer Left Widget Area.
        register_sidebar(array(
            'name' => __('Homepage Above Footer Left Widget Area', 'tfbasedetails'),
            'id' => 'above-footer-widget-area-left',
            'description' => __('The content will be displayed just above your footer - to the left.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        // Above Footer Right Widget Area.
        register_sidebar(array(
            'name' => __('Homepage Above Footer Right Widget Area', 'tfbasedetails'),
            'id' => 'above-footer-widget-area-right',
            'description' => __('The content will be displayed just above your footer - to the right.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        // First Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('First Footer Widget Area', 'tfbasedetails'),
            'id' => 'first-footer-widget-area',
            'description' => __('The first footer widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Second Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Second Footer Widget Area', 'tfbasedetails'),
            'id' => 'second-footer-widget-area',
            'description' => __('The second footer widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Third Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Third Footer Widget Area', 'tfbasedetails'),
            'id' => 'third-footer-widget-area',
            'description' => __('The third footer widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Fourth Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Fourth Footer Widget Area', 'tfbasedetails'),
            'id' => 'fourth-footer-widget-area',
            'description' => __('The fourth footer widget area', 'tfbasedetails'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Top Left Widget Area 1, Displayed on homepage.
        register_sidebar(array(
            'name' => __('Homepage Top Left Widget Area 1', 'tfbasedetails'),
            'id' => 'first-top-right-widget-area',
            'description' => __('The content will be displayed in the first top right widget area.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Homepage Top Left Widget Area 2, Displayed on homepage.
        register_sidebar(array(
            'name' => __('Homepage Top Left Widget Area 2', 'tfbasedetails'),
            'id' => 'second-top-right-widget-area',
            'description' => __('The content will be displayed in the second top right widget area.', 'tfbasedetails'),
            /* 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
              'after_widget' => '</li>', */
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

    }



    /** Register sidebars by running tfbasedetails_widgets_init() on the widgets_init hook. */
    add_action('widgets_init', 'tfbasedetails_widgets_init');

    /**
     * Removes the default styles that are packaged with the Recent Comments widget.
     *
     * To override this in a child theme, remove the filter and optionally add your own
     * function tied to the widgets_init action hook.
     *
     * @since Twenty Ten 1.0
     */
    function tfbasedetails_remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }

    add_action('widgets_init', 'tfbasedetails_remove_recent_comments_style');

    if (!function_exists('tfbasedetails_posted_on')) :

        /**
         * Prints HTML with meta information for the current post date/time and author.
         *
         * @since Twenty Ten 1.0
         */
        function tfbasedetails_posted_on() {
            printf(__('%2$s <span class="meta-sep">by</span> %3$s', 'tfbasedetails'), 'meta-prep meta-prep-author', sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()
                    ), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', 'tfbasedetails'), get_the_author()), get_the_author()
                    )
            );
        }

    endif;

    if (!function_exists('tfbasedetails_img_posted_on')) :

        /**
         * Prints HTML with meta information for the current post date/time and author.
         *
         * @since Twenty Ten 1.0
         */
        function tfbasedetails_img_posted_on() {
            printf(__('%2$s', 'tfbasedetails'), 'meta-prep meta-prep-author', sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-img-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()
                    ), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', 'tfbasedetails'), get_the_author()), get_the_author()
                    )
            );
        }

    endif;

    if (!function_exists('tfbasedetails_posted_in')) :

        /**
         * Prints HTML with meta information for the current post (category, tags and permalink).
         *
         * @since Twenty Ten 1.0
         */
        function tfbasedetails_posted_in() {
            // Retrieves tag list of current post, separated by commas.
            $tag_list = get_the_tag_list('', ', ');
            if ($tag_list) {
                $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tfbasedetails');
            } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
                $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tfbasedetails');
            } else {
                $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tfbasedetails');
            }
            // Prints the string, replacing the placeholders.
            printf(
                    $posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0')
            );
        }

    endif;

// add category nicenames in body and post class
    function category_id_class($classes) {
        global $post;
        foreach ((get_the_category($post->ID)) as $category)
            $classes[] = $category->category_nicename;
        return $classes;
    }

    add_filter('post_class', 'category_id_class');
    add_filter('body_class', 'category_id_class');

    function tf_bcrumbs() {
        if (function_exists('bcn_display')) {
            ?>
            <nav id="crumbs">
                <div id="breadcrumb">
                    <?php bcn_display(); ?>
                </div>
            </nav>
            <?php
        }
    }

// added per WP upload process request
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
        add_image_size('hp-prod-thumbnail', 450, 250, true); // Homepage thumbnail size
        add_image_size('tiny-post-thumbnail', 60, 60, true); // Tiny thumbnail size - used for small blog updates on HP
        add_image_size('showcase-hp', 204, 204, true); // Showcase HP thumbnail
        add_image_size('showcase-2col', 446, 290, true); // Showcase 3Col thumbnail
        add_image_size('showcase-3col', 284, 205, true); // Showcase 3Col thumbnail
        add_image_size('showcase-4col', 204, 204, true); // Showcase 3Col thumbnail
        add_image_size('showcase-page', 930, 410, true); // Showcase Page thumbnail
        add_image_size('showcase-hpwidget', 435, 250, true); // Showcase Page thumbnail
        add_image_size('slide-hp-flex-default', 609, 359, true); // HP Slide Large Image
        add_image_size('slide-hp-flex-wide', 990, 450, true); // HP Slide Large Image
        add_image_size('pg-feat-wide', 930, 370, true); // Featured images for standard pages and blog post summaries
        add_image_size('pg-feat', 690, 370, true); // Featured images for standard pages and blog post summaries
        add_image_size('blog-single', 690, 370, true); // Featured images for standard pages
        add_image_size('shop-prod-details-thumb', 90, 90, true);
        add_image_size('category_thumb', 80, 80, true);
        add_image_size('woocat_thumb', 80, 80, true);
    }

    class Walker_Category_Filter extends Walker_Category {

        function start_el(&$output, $category, $depth, $args) {

            extract($args);
            $cat_name = esc_attr($category->name);
            $cat_name = apply_filters('list_cats', $cat_name, $category);
            $link = '<a href="#" data-value="' . strtolower(preg_replace('/\s+/', '-', $cat_name)) . '" ';
            if ($use_desc_for_title == 0 || empty($category->description))
                $link .= 'title="' . sprintf(__('View all posts filed under %s', 'tfbasedetails'), $cat_name) . '"';
            else
                $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
            $link .= '>';
            // $link .= $cat_name . '</a>';
            $link .= $cat_name;
            if (!empty($category->description)) {
                $link .= ' <span>' . $category->description . '</span>';
            }
            $link .= '</a>';
            if ((!empty($feed_image)) || (!empty($feed))) {
                $link .= ' ';
                if (empty($feed_image))
                    $link .= '(';
                $link .= '<a href="' . get_category_feed_link($category->term_id, $feed_type) . '"';
                if (empty($feed))
                    $alt = ' alt="' . sprintf(__('Feed for all posts filed under %s', 'tfbasedetails'), $cat_name) . '"';
                else {
                    $title = ' title="' . $feed . '"';
                    $alt = ' alt="' . $feed . '"';
                    $name = $feed;
                    $link .= $title;
                }
                $link .= '>';
                if (empty($feed_image))
                    $link .= $name;
                else
                    $link .= "<img src='$feed_image'$alt$title" . ' />';
                $link .= '</a>';
                if (empty($feed_image))
                    $link .= ')';
            }
            if (isset($show_count) && $show_count)
                $link .= ' (' . intval($category->count) . ')';
            if (isset($show_date) && $show_date) {
                $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
            }
            if (isset($current_category) && $current_category)
                $_current_category = get_category($current_category);
            if ('list' == $args['style']) {
                $output .= '<li class="segment-' . rand(2, 99) . '"';
                $class = 'cat-item cat-item-' . $category->term_id;
                if (isset($current_category) && $current_category && ($category->term_id == $current_category))
                    $class .= ' current-cat';
                elseif (isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent))
                    $class .= ' current-cat-parent';
                $output .= '';
                $output .= ">$link\n";
            } else {
                $output .= "\t$link<br />\n";
            }
        }

    }

    /* ----------------------------------------------------------------------------------- */
    /* Custom Walker for wp_list_categories in template-portfolio.php */
    /* ----------------------------------------------------------------------------------- */

    class Showcase_Walker extends Walker_Category {

        function start_el(&$output, $category, $depth, $args) {
            extract($args);

            $cat_name = esc_attr($category->name);
            $cat_name = apply_filters('list_cats', $cat_name, $category);
            $link = '<a href="' . esc_attr(get_term_link($category)) . '" ';
            $link .= 'data-filter="' . $category->slug . '" ';
            if ($use_desc_for_title == 0 || empty($category->description))
                $link .= 'title="' . esc_attr(sprintf(__('View all posts filed under %s', 'tfbasedetails'), $cat_name)) . '"';
            else
                $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
            $link .= '>';
            $link .= $cat_name . '</a>';

            if (!empty($feed_image) || !empty($feed)) {
                $link .= ' ';

                if (empty($feed_image))
                    $link .= '(';

                $link .= '<a href="' . get_term_feed_link($category->term_id, $category->taxonomy, $feed_type) . '"';

                if (empty($feed)) {
                    $alt = ' alt="' . sprintf(__('Feed for all posts filed under %s', 'tfbasedetails'), $cat_name) . '"';
                } else {
                    $title = ' title="' . $feed . '"';
                    $alt = ' alt="' . $feed . '"';
                    $name = $feed;
                    $link .= $title;
                }

                $link .= '>';

                if (empty($feed_image))
                    $link .= $name;
                else
                    $link .= "<img src='$feed_image'$alt$title" . ' />';

                $link .= '</a>';

                if (empty($feed_image))
                    $link .= ')';
            }

            if (!empty($show_count))
                $link .= ' (' . intval($category->count) . ')';

            if (!empty($show_date))
                $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);

            if ('list' == $args['style']) {
                $output .= "\t<li";
                $class = 'cat-item cat-item-' . $category->term_id;
                if (!empty($current_category)) {
                    $_current_category = get_term($current_category, $category->taxonomy);
                    if ($category->term_id == $current_category)
                        $class .= ' current-cat';
                    elseif ($category->term_id == $_current_category->parent)
                        $class .= ' current-cat-parent';
                }
                $output .= ' class="' . $class . '"';
                $output .= ">$link\n";
            } else {
                $output .= "\t$link<br />\n";
            }
        }

    }

    /* ----------------------------------------------------------------------------------- */
    /*  Add home icon to main menus
    /*----------------------------------------------------------------------------------- */


    function add_homeicon ($items, $args) {
        if ( isset( $args->walker ) && is_object( $args->walker ) && method_exists( $args->walker, 'is_mainmenu' ) ) {

            $icon = '<li class="homeicon"><a href="' . home_url() . '"><i class="icon-home"></i></a></li>';           
            $items = $icon . $items;
        }
        return $items;
    }
    add_filter('wp_nav_menu_items', 'add_homeicon', 10, 2);

    /* ----------------------------------------------------------------------------------- */
    /* 	New menu walker for the nav_menu menu
    /*----------------------------------------------------------------------------------- */

    class menu_walker extends Walker_Nav_Menu {

    // easy way to check it's this walker we're using to mod the output
        function is_mainmenu() {
            return true;
        }


        function start_el(&$output, $item, $depth, $args) {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat("", $depth) : '';

            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
            $class_names = ' class="' . esc_attr($class_names) . '"';

            $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

            $prepend = '';
            $append = '';
            $description = !empty($item->description) ? '<span>' . esc_attr($item->description) . '</span>' : '';

            if ($depth != 0) {
                $description = $append = $prepend = "";
            }

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '><span>';
            $item_output .= $args->link_before . $prepend . apply_filters('the_title', $item->title, $item->ID) . $append;
            $item_output .= '</span></a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

    /**
     * Grab the first URL from a Link post
     */
    function tfbasedetails_url_grabber() {
        global $post, $posts;
        $first_url = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<a.+href=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_url = $matches [1] [0];
        if (empty($first_url))
            return false;
        return $first_url;
    }

    /* ----------------------------------------------------------------------------------- */
    /* Add Favicon
      /*----------------------------------------------------------------------------------- */

    function tf_favicon() {
        $GLOBALS['favicon'] = get_option('tf_favicon');
        if ($GLOBALS['favicon'] != '')
            echo '<link rel="shortcut icon" href="' . $GLOBALS['favicon'] . '"/>' . "\n";
    }

    add_action('wp_head', 'tf_favicon');


    /* ----------------------------------------------------------------------------------- */
    /* Use the correct link if lightbox is on/off and include video if needed
      /*----------------------------------------------------------------------------------- */

    function tf_showcasethumb($postid, $related = FALSE) {

        if (is_page_template('template_showcase_4col.php')) {

            $thumb = get_the_post_thumbnail($postid, 'showcase-4col', array('class' => 'thumbnail'));

            if ($thumb == '') {
                $thumb = '<img src="' . $thumb . '" alt="' . get_the_title() . '" class="thumbnail" />';
            }

            $output = '<a title="' . get_the_title($postid) . '" href="' . get_permalink($postid) . '"><span class="overlay"></span>' . $thumb . '</a>';

            echo $output;
        } elseif (is_page_template('template_showcase_3col.php')) {

            $thumb = get_the_post_thumbnail($postid, 'showcase-3col', array('class' => 'thumbnail'));

            if ($thumb == '') {
                $thumb = '<img src="' . $thumb . '" alt="' . get_the_title() . '" class="thumbnail" />';
            }

            $output = '<a title="' . get_the_title($postid) . '" href="' . get_permalink($postid) . '"><span class="overlay"></span>' . $thumb . '</a>';

            echo $output;
        } elseif (is_page_template('template_showcase_2col.php')) {

            $thumb = get_the_post_thumbnail($postid, 'showcase-2col', array('class' => 'thumbnail'));

            if ($thumb == '') {
                $thumb = '<img src="' . $thumb . '" alt="' . get_the_title() . '" class="thumbnail" />';
            }

            $output = '<a title="' . get_the_title($postid) . '" href="' . get_permalink($postid) . '"><span class="overlay"></span>' . $thumb . '</a>';

            echo $output;
        }
    }

