<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 *
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if (!is_active_sidebar('first-footer-widget-area') && !is_active_sidebar('second-footer-widget-area') && !is_active_sidebar('third-footer-widget-area')
)
    return;
// If we get this far, we have widgets. Let do this.
?>

<?php if (is_active_sidebar('first-footer-widget-area')) : ?>
    <section class="first-footer-widget one_fourth first">
        <?php dynamic_sidebar('first-footer-widget-area'); ?>
    </section>
<?php endif; ?>


<section class="three_fourth">

<?php if (get_option('tf_logotag') != null) : ?>
    <h4 class="strap"><?php echo get_option('tf_logotag'); ?></h4>
<?php endif; ?>      

<?php if (is_active_sidebar('second-footer-widget-area')) : ?>
    <section class="second-footer-widget one_third first">
        <?php dynamic_sidebar('second-footer-widget-area'); ?>
    </section>
<?php endif; ?>

<?php if (is_active_sidebar('third-footer-widget-area')) : ?>
    <section class="third-footer-widget one_third">
        <?php dynamic_sidebar('third-footer-widget-area'); ?>
    </section>
<?php endif; ?>

<?php if (is_active_sidebar('fourth-footer-widget-area')) : ?>
    <section class="fourth-footer-widget one_third last">
        <?php dynamic_sidebar('fourth-footer-widget-area'); ?>
    </section>
<?php endif; ?>
</section>