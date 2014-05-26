<?php
/**
 * The Homepage Center Bottom widget area.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 * The center widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 */
?>

<section id="center-bottom-widget-area-wrapper">
    <aside id="center-bottom-widget-area" role="complementary">
        <?php if (is_active_sidebar('first-center-bottom-widget-area')) : ?>
            <section id="first-center-bottom-widget" class="widget-area">
                    <?php dynamic_sidebar('first-center-bottom-widget-area'); ?>
            </section>
        <?php endif; ?>
        <?php if (is_active_sidebar('second-center-bottom-widget-area')) : ?>
            <section id="second-center-bottom-widget" class="widget-area">
                    <?php dynamic_sidebar('second-center-bottom-widget-area'); ?>
            </section>
        <?php endif; ?>      
        <?php if (is_active_sidebar('above-footer-widget-area-left')) : ?>
            <section id="above-footer-widget-intro" class="widget-area one_half first">
                    <?php dynamic_sidebar('above-footer-widget-area-left'); ?>
            </section>        
            <section id="above-footer-widget" class="widget-area one_half">
                    <?php dynamic_sidebar('above-footer-widget-area-right'); ?>
            </section>
        <?php endif; ?>
        <?php
        //Reset Query
        wp_reset_query();
        ?>
    </aside>
</section>