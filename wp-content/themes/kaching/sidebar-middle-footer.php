<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 *
 * The middle footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
//if (!is_active_sidebar('first-top-footer-widget-area') && !is_active_sidebar('second-top-footer-widget-area'))
//    return;
// If we get this far, we have widgets. Let do this.
?>
    <section class="first-middle-footer-widget two_third first">
    <?php if (get_option('tf_enable_footer_promo') == 'true') : ?>
        <div class="footer_promo">
            <a href="<?php echo get_option('tf_footer_promo_link'); ?>"><?php echo get_option('tf_footer_promo_text'); ?></a>
        </div>
    <?php endif; ?>

    </section>
    <section class="one_third">
    <?php if (get_option('tf_enable_smicons') == 'true') : ?>
        <div class="social-icons"> 
            <?php if (get_option('tf_fb_link') != null) : ?>
                <a class="facebook" href="<?php echo get_option('tf_fb_link'); ?>">f</a>
            <?php endif; ?>            
            <?php if ((get_option('tf_fb_link') != null) && ((get_option('tf_tw_link') != null))) : ?>
            <?php endif; ?>
            <?php if (get_option('tf_tw_link') != null) : ?>
                <a class="twitter" href="<?php echo get_option('tf_tw_link'); ?>">l</a> 
            <?php endif; ?>
            <?php if (get_option('tf_gplus_link') != null) : ?>
                <?php if ((get_option('tf_fb_link') != null) || ((get_option('tf_tw_link') != null))) : ?>
                <?php endif; ?>     
                <a class="google" href="<?php echo get_option('tf_gplus_link'); ?>">g</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </section>