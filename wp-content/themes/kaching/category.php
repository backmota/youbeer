<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
get_header();
?>
<div id="wrap_all">
    <section id="contents" role="main">
        <div class="container">
            <div class="pgtitle">
                <h1>
                    <?php
                    printf(__('Category Archives: %s', 'tfbasedetails'), '' . single_cat_title('', false) . '');
                    ?>
                </h1>
            </div>
            <div class="content generic nine alpha units">
                <div id="content">
                    <?php
                    /* Run the loop for the tag archive to output the posts
                     * If you want to overload this in a child theme then include a file
                     * called loop-tag.php and that will be used instead.
                     */
                    get_template_part('loop', 'category');
                    ?>
                    <div class="clearboth"></div>
                </div>
            </div>
            <aside id="sidebar-right" class="units three">
                <div id="sidebar_content" class="sidebar sidebar_right">
                    <?php get_sidebar(); ?>
                </div>

                <div id="sidebar_bottom"></div>
            </aside>
        </div>

        <div class="clearboth"></div>
    </section>
    <?php get_footer(); ?>
