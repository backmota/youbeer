<?php
/**
 * The Homepage Top Right widget area.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 * The center widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if (!is_active_sidebar('first-top-right-widget-area')
)
    return;
// If we get this far, we have widgets. Let do this.
?>
<section id="top-right-widget-area-wrapper">
    <aside id="top-right-widget-area" role="complementary">
        <?php if (is_active_sidebar('first-top-right-widget-area')) : ?>
            <section id="first-top-right-widget" class="widget-area">
                <ul>
                    <?php dynamic_sidebar('first-top-right-widget-area'); ?>
                </ul>
            </section>
        <?php endif; ?>
        <?php if (is_active_sidebar('second-top-right-widget-area')) : ?>
            <section id="second-top-right-widget-area" class="widget-area">
                <ul>
                    <?php dynamic_sidebar('second-top-right-widget-area'); ?>
                </ul>
            </section>
        <?php endif; 
        //Reset Query
        wp_reset_query();
        ?>
    </aside>
</section>