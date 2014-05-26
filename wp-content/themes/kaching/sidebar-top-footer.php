<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 *
 * The top footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
//if (!is_active_sidebar('first-top-footer-widget-area') && !is_active_sidebar('second-top-footer-widget-area'))
//    return;
// If we get this far, we have widgets. Let do this.
?>
    <section class="first-top-footer-widget two_third first">
        <div class="footer_cta one_half first">
        <?php if (get_option('tf_footerctaphone') != null) : ?>
        <span><i class="icon-phone"></i><?php _e('Phone', 'tfbasedetails'); ?></span>
        <p><?php echo get_option('tf_footerctaphone'); ?></p>
        <?php endif; ?> 
        </div>
        <div class="footer_cta one_half">
        <?php if (get_option('tf_footerctaemail') != null) : ?>
        <span><i class="icon-envelope"></i><?php _e('Email', 'tfbasedetails'); ?></span>
        <p><?php echo get_option('tf_footerctaemail'); ?></p>
        <?php endif; ?> 
        </div>
    </section>
    <section class="one_third">
        <?php if (get_option('tf_enable_ccicons') != null) : ?>

        <ul class="ccicons">
        <?php if (get_option('tf_enable_ccvisa') == 'true') : ?>            
            <li>
                <img src="<?php echo get_template_directory_uri(); ?>/images/cc_visa.png" alt="Visa">
            </li>
        <?php endif; ?>
        <?php if (get_option('tf_enable_ccmc') == 'true') : ?>            
            <li>
                <img src="<?php echo get_template_directory_uri(); ?>/images/cc_mc.png" alt="Mastercard">
            </li>
        <?php endif; ?>
        <?php if (get_option('tf_enable_ccpaypal') == 'true') : ?>            
            <li>
                <img src="<?php echo get_template_directory_uri(); ?>/images/cc_paypal.png" alt="Paypal">
            </li>
        <?php endif; ?>
        <?php if (get_option('tf_enable_ccamex') == 'true') : ?>            
            <li>
                <img src="<?php echo get_template_directory_uri(); ?>/images/cc_amex.png" alt="Amercian Express">
            </li>
        <?php endif; ?>
        </ul>

        <?php endif; ?>
    </section>