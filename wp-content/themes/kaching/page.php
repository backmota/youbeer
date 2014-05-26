<?php
/**
 * Template Name: Default :: Page
 * The main page template file.
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
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
            <div class="content generic nine alpha units">
                <div id="content">
                    <?php if (have_posts())
                        while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php the_post_thumbnail('pg-feat', array('class' => 'thumbnail')); ?>
                                    <div class="thecontent">
                                        <?php the_content(); ?><?php wp_link_pages(array('before' => '' . __('Pages:', 'tfbasedetails'), 'after' => '')); ?>
                                    </div>
                                </div><!-- .entry-content -->
                            </article><!-- #post-## -->
                            <div class="clearboth"></div>
                            <?php 
                            $hidecomments = get_theme_mod( 'tf_hide_comments', 'no' );
                            if ($hidecomments == 'no') {
                            }
                            else {
                                comments_template('', true); 
                            }
                            ?>
                        <?php endwhile; // end of the loop.         ?>
                </div>
            </div>
           
        </div>
        <div class="clearboth"></div>
    </section><!-- #main -->
    <?php get_footer(); ?>