<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 *
 * When we call the dynamic_sidebar() function, it'll spit out
 * the widgets for that widget area. If it instead returns false,
 * then the sidebar simply doesn't exist, so we'll hard-code in
 * some default sidebar stuff just in case.
 */
if (!dynamic_sidebar('primary-widget-area')) :
    ?>
    <?php if (current_user_can('switch_themes')) { ?>
        <h3 class="widget-title">Admin Message!</h3>
        <div class="textwidget">
            <p>Hey there! We built your theme to be widget ready. We'd highly recommend that you head on over to the Wordpress Admin and go into the Widgets admin area and go ahead and add some widgets to the <strong>Primary Widget Area</strong> which will override the display of the usual "Pages, Archives, Meta" stuff below. Oh and don't worry - only admins see this message :)</p>
        </div>
    <?php } ?>
    <h3 class="widget-title"><?php _e('Search', 'tfbasedetails'); ?></h3>
    <div>
        <?php get_search_form(); ?>
    </div>
    <h3 class="widget-title"><?php _e('Archives', 'tfbasedetails'); ?></h3>
    <div>
        <?php wp_get_archives('type=monthly'); ?>
    </div>
    <h3 class="widget-title"><?php _e('Meta', 'tfbasedetails'); ?></h3>
    <div>
        <?php wp_register(); ?>
        <li><?php wp_loginout(); ?></li>
        <?php wp_meta(); ?>
    </div>
<?php endif; ?>