<?php
/**
 * Template Name: Shop Homepage :: Wide Slider
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
get_header();
?>
<div id="wrap_all">
    <aside id="hpslider" class="clearfix">
            <div class="hpslider">
                <div class="home-banner-wrap preloading flexslider">
                    <ul class="slides">
                        <?php
                        remove_filter('pre_get_posts', 'wploop_exclude');
                        $query_string = "post_type=tf_hpslide&posts_per_page=10";
                        query_posts($query_string);
                        if (have_posts()) : while (have_posts()) : the_post();
                                $jcycle_url = get_post_meta($post->ID, '_jcycle_url_value', true);
                                ?>
                                <li class="slide">
                                    <?php
                                    $isslideractive = get_theme_mod( 'tf_hp_slides', 'yes' );
                                    if ($isslideractive == 'no') {
                                    ?>
                                    <a href="<?php echo get_post_meta($post->ID, 'hpslide_url', true); ?>">
                                    <?php 
                                    }
                                    get_the_image(array('size' => 'slide-hp-flex-wide', 'echo' => true, 'link_to_post' => false, 'width' => 930, 'height' => 347)); 
                                    if ($isslideractive == 'no') {
                                    ?>
                                    </a>
                                    <?php } ?>
                                    <?php if ($isslideractive == 'yes') { ?>
                                    <div class="hpslides">
                                        <h2><a href="<?php echo get_post_meta($post->ID, 'hpslide_url', true); ?>"><?php the_title(); ?></a></h2>
                                        <?php echo the_excerpt(); ?>
                                        
                                        <?php if (get_post_meta($post->ID, 'hpslide_pricemsg', true)) { ?>
                                            <div class="hpslide_pricewrap">
                                                <a href="<?php echo get_post_meta($post->ID, 'hpslide_url', true); ?>">
                                                    <span class="hpslide_pricemsg"><?php echo get_post_meta($post->ID, 'hpslide_pricemsg', true); ?></span>
                                                    <span class="hpslide_price"><?php echo get_post_meta($post->ID, 'hpslide_price', true); ?></span>
                                                </a>
                                            </div> 
                                        <?php }
                                        ?>     
                                    </div>
                                        <?php
                                        }
                                        ?>   
                                </li>   
                                <?php
                            endwhile;
                        endif;
                        wp_reset_query();
                        ?>
                    </ul>
                </div>
            </div> 
    </aside>    
        <section id="hpmiddle" role="contentinfo" class="container">
        <div class="content twelve alpha units">
            <?php get_sidebar('center-middle'); ?>
        </div>
    </section>  
    <section id="hpshop" role="contentinfo" class="container clearfix">
        <section class="woohpwidgets-main">
                <div class="hpleft clearfix">
                    <?php get_sidebar('center-bottom'); ?>
                </div>
        </section>
    </section>  
    <div class="clearboth"></div>
    <?php get_footer(); ?>