<?php
/**
 * The template for displaying Search Results pages.
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
                    <?php if (have_posts()) : ?>
                        <?php printf(__('Search Results for: %s', 'tfbasedetails'), '' . get_search_query() . ''); ?>
                    <?php else : ?>
                        <?php _e('Nothing Found', 'tfbasedetails'); ?>
                    <?php endif; ?>
                </h1>
            </div>
            <div class="content nine alpha units">
                <div id="content">
                    <?php if (have_posts()) : ?>
                        <?php
                        /* Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called loop-search.php and that will be used instead.
                         */
                        get_template_part('loop', 'search');
                        ?>
                    <?php else : ?>

                        <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'tfbasedetails'); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>

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
