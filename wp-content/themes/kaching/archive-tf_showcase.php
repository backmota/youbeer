<?php
/**
 * Template Name: Showcase :: Archive
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
                    <?php
                    $args = array('post_type' => 'tf_slideshow', 'posts_per_page' => 10);
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) : $loop->the_post();
                        the_title();
                        echo '<div class="entry-content">';
                        the_content();
                        echo '</div>';
                    endwhile;
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