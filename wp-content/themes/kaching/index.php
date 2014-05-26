<?php
/**
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
                <h1><?php echo stripslashes(get_option('tf_blogpagetitle')); ?></h1>
            </div>
            <div class="content generic nine alpha units"> 

                <div id="content">
                    <?php if (have_posts()) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('content', get_post_format()); ?>
                        <?php endwhile; ?>
                        <?php /* Display navigation to next/previous pages when applicable */ ?>
                        <?php if ($wp_query->max_num_pages > 1) : ?>
                            <nav id="nav-below" class="navigation">
                                <?php //next_posts_link(__('&larr; Older posts', 'tfbasedetails')); ?>
                                <?php kriesi_pagination(); ?>
                                <?php //previous_posts_link(__('Newer posts &rarr;', 'tfbasedetails')); ?>
                            </nav>
                        <?php endif; ?>
                    <?php else : ?>
                        <article id="post-0" class="post no-results not-found">
                            <header class="entry-header">
                                <h1 class="entry-title"><?php _e('Nothing Found', 'tfbasedetails'); ?></h1>
                            </header><!-- .entry-header -->
                            <div class="entry-content">
                                <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'tfbasedetails'); ?></p>
                                <?php get_search_form(); ?>
                            </div>
                        </article>
                    <?php endif; ?>
                </div>
            </div>
            <aside id="sidebar-right" class="units three">
                <div id="sidebar_content" class="lessgap sidebar sidebar_right">
                    <?php get_sidebar(); ?>
                </div>
                <div id="sidebar_bottom"></div>
            </aside>
        </div>
        <div class="clearboth"></div>
    </section>
    <?php get_footer(); ?>
