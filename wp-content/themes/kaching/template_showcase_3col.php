<?php
/**
 * Template Name: Showcase:: 3 columns
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
            <div class="scasetop">
                <div class="scase-pgtitle">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div id="showcase_cats" class="clearfix">
                            <h2><?php _e('Filter by', 'tfbasedetails'); ?></h2>                    
                            <ul id="sort-by" class="clearfix">
                                <li><a href="#all" data-filter="tf_showcase" class="active"><?php _e('All', 'tfbasedetails'); ?></a></li>
                                <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'tf_showcasecategory', 'walker' => new Showcase_Walker())); ?>
                            </ul>
                        </div>
                    </div>
                    <div class="scase content twelve alpha units">
                        <div id="content">
                            <section id="showcasecontainer" role="contentinfo">
                                <div class="showcasecontent clearfix">
                                    <?php the_content(); ?>
                                </div>
                                <div class="clearboth"></div>
                            <?php endwhile;
                        endif; // end of the loop.  ?>
                        <div id="showcase-wrap" class="threecolwrap">
                            <ul id="sclist-wrap" class="image-grid-three isotope">
                                <?php
                                $args = array(
                                    'post_type' => 'tf_showcase',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC',
                                    'posts_per_page' => -1
                                );
                                $query = new WP_Query($args);

                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <?php
                                    $terms = get_the_terms($post->ID, 'tf_showcasecategory');
                                    $term_list = '';
                                    if (is_array($terms)) {
                                        foreach ($terms as $term) {
                                            $term_list .= $term->slug;
                                            $term_list .= ' ';
                                        }
                                    }
                                    ?>
                                    <li <?php post_class("$term_list threecol isotope-item one_half"); ?> id="post-<?php the_ID(); ?>">
                                        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">   
                                            <div class="post-thumb">
                                                <?php tf_showcasethumb(get_the_ID()); ?>
                                            </div>
                                            <h2 class="sc-entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'tfbasedetails'), get_the_title()); ?>"> <?php the_title(); ?></a> <?php edit_post_link(__('edit', 'tfbasedetails'), '<span class="edit-post">[', ']</span>'); ?></h2>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
                        </div>
                </div>
                </section>
                <?php get_footer(); ?>