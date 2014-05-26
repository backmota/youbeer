<?php
/**
 * Template Name: Sidebar Left - No subnav
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
                <h1><?php the_title(); ?></h1>
            </div>
            <aside id="sidebar-left" class="units three">
                <div id="sidebar_content">
                    <?php get_sidebar(); ?>
                </div>
                <div id="sidebar_bottom"></div>
            </aside>
            <div class="content generic nine units">
                <div id="content">
                    <?php if (have_posts())
                        while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php the_post_thumbnail('pg-feat'); ?>
                                    <div class="thecontent">
                                        <?php the_content(); ?><?php wp_link_pages(array('before' => '' . __('Pages:', 'tfbasedetails'), 'after' => '')); ?>
                                    </div>
                                </div>
                            </article>
                            <div class="clearboth"></div>
                            <?php 
                            $hidecomments = get_theme_mod( 'tf_hide_comments', 'no' );
                            if ($hidecomments == 'no') {
                            }
                            else {
                                comments_template('', true); 
                            }
                            ?>
                        <?php endwhile; // end of the loop.     ?>
                </div>
                <div class="clearboth"></div>
            </div>
        </div>
    </section>
    <?php get_footer(); ?>