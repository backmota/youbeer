<?php
/**
 * 
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
global $woo_options;
global $woocommerce;
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<html <?php language_attributes(); ?> class="no-js">
    <!--<![endif]-->

    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php tf_wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon-precomposed.png" />
        <?php
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');
        ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class('boxed'); ?>>
        <header id="top" role="banner">
            <div id="toplinks">
                <div class="container">
                    <div id="vtoplinks" class="clearfix">
                        <div class="sub_menu">
                            <?php
                            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                                echo tf_shop_nav();
                            }
                            ?>
                        </div>
                        <?php if (get_option('tf_enable_headercta') == 'true') : ?>
                            <div id="slogan">
                                <i class="icon-phone"></i><?php echo get_option('tf_headercta'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="topbar">
                <div class="topwrap">
                    <div class="container">
                        <div id="toptop" class="clearfix">
                        <div id="logosearch" class="clearfix">
                            <?php /*
                              If "plain text logo" is set in theme options then use text
                              if a logo url has been set in theme options then use that
                              if none of the above then use the default logo.png */
                            if (get_option('tf_logotype') == 'text') { ?>
                                <div class="headerwrap one_half first">
                                    <h1><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php echo get_option('tf_textlogo'); ?></a></h1>
                                </div>        
                            <?php } elseif ((get_option('tf_logotype') == 'image')) { ?>
                                <div class="headerwrap-img one_half first">
                                    <a href="<?php echo home_url(); ?>" class="logolink"><img src="<?php echo get_option('tf_sitelogo'); ?>" alt="<?php bloginfo('name'); ?>" class="tflogo"></a> 
                                </div>
                                    
                            <?php } else { ?> 

                                <div class="headerwrap-img one_half first">
                                    <a href="<?php echo home_url(); ?>" class="logolink"><img src="<?php echo get_template_directory_uri(); ?>/images/logo2by.png" alt="<?php bloginfo('name'); ?>" class="tflogo"></a> </div> <?php } ?>
                            <div class="header-widget one_half">
                                <?php
                                    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                                    ?>
                                        <?php if (get_option('tf_enable_wooheadercart') == 'true') : ?>
                                            <?php echo tf_woocommerce_cart_dropdown(); ?>
                                        <?php endif; ?>                                    
                                    <?php }
                            ?>

                                <?php dynamic_sidebar('header-widget-area'); ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="navwrap">
                <div class="container">
                    <?php echo tf_main_nav(); ?>
                </div>
            </div>  
        </header>