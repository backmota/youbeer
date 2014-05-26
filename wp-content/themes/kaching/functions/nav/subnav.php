<?php

/**
 * Sub Navigation walker call
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>

<?php

if (function_exists('wp_nav_menu')) {
    echo '<div id="sub_nav">';
    ?>
    <p class="leftnavtitle"><?php _e('In this section', 'tfbasedetails'); ?></p>
    <?php

    $issubmenu = wp_nav_menu(array(
        'container' => false,
        'theme_location' => 'Main Navigation',
        'sort_column' => 'menu_order',
        'menu_class' => 'tfsubmenu',
        'echo' => true,
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'walker' => new sub_nav_walker())
    );

    echo $issubmenu;
    echo '</div><!-- end sub_nav -->';
}
?>