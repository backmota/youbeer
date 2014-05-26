<?php
/**
 * The Homepage Center Middle widget area.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 * The center widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
//if (!is_active_sidebar('first-center-middle-widget-area'))
//    return;
// If we get this far, we have widgets. Let do this.
?>

<section id="center-middle-widget-area-wrapper" class="clearfix">
    <aside id="center-middle-widget-area" role="complementary">
        <div class="dealwidgethead">
            
        </div>
        <div class="homepage-top-widget-area clearfix">
            <?php dynamic_sidebar('homepage-top-widget-area'); ?>
        </div>
        <div class="deals clearfix">
            <?php if (is_active_sidebar('first-center-middle-widget-area')) : ?>
                <section id="first-center-middle-widget" class="widget-area one_third first">
                    <ul>
                        <?php dynamic_sidebar('first-center-middle-widget-area'); ?>
                    </ul>
                </section>
            <?php endif; ?>
            <?php if (is_active_sidebar('second-center-middle-widget-area')) : ?>
                <section id="second-center-middle-widget" class="widget-area one_third">
                    <ul>
                        <?php dynamic_sidebar('second-center-middle-widget-area'); ?>
                    </ul>
                </section>
            <?php endif; ?>
            <?php if (is_active_sidebar('third-center-middle-widget-area')) : ?>
                <section id="third-center-middle-widget" class="widget-area one_third">
                    <ul>
                        <?php dynamic_sidebar('third-center-middle-widget-area'); ?>
                    </ul>
                </section>
            <?php endif; ?>                   
            <?php
            //Reset Query
            wp_reset_query();
            ?>
        </div>
    </aside>
</section>