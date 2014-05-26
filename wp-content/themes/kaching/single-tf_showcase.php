<?php
/**
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
                    <h1><?php the_title(); ?></h1>
                </div>
                <div id="showcase_cats" class="clearfix">
                    <nav id="scasenav">
                        <?php if (get_previous_post()) : ?>
                            <div class="nav-previous"><?php previous_post_link('%link') ?></div>
                        <?php endif; ?>

                        <?php if (get_next_post()) : ?>
                            <div class="nav-next"><?php next_post_link('%link') ?></div>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
            <div class="content twelve alpha units">
                <div id="content">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                            <?php if (get_post_meta(get_the_ID(), 'tf_embed', true) == "") { ?>

                                <div id="showcaseimg">

                                    <section class="slides">
                                        <div id="slider" class="nivoSlider">

                                            <?php
                                            global $wpdb, $post;

                                            $website = get_post_meta($post->ID, 'tf_sclink', true);
                                            $shdesc = get_post_meta($post->ID, 'tf_scasedescription', true);
                                            $meta = get_post_meta($post->ID, 'tf_scasescreenshot', false);

                                            if (!is_array($meta))
                                                $meta = (array) $meta;
                                            if (!empty($meta)) {
                                                $meta = implode(',', $meta);
                                                $images = $wpdb->get_col("
                        SELECT ID FROM $wpdb->posts
                        WHERE post_type = 'attachment'
                        AND ID IN ( $meta )
                        ORDER BY menu_order ASC
                        ");
                                                foreach ($images as $att) {
                                                    // Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
                                                    $src = wp_get_attachment_image_src($att, 'showcase-page');
                                                    $src2 = wp_get_attachment_image_src($att, '');
                                                    $src = $src[0];
                                                    $src2 = $src2[0];
                                                    echo "<img src='{$src}' />";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </section>    
                                </div>                

                            </div>

        <?php } else { ?>

                            <div id="showcaseimg">
                                <?php
                                if (get_post_meta(get_the_ID(), 'tf_source', true) == 'vimeo') {
                                    echo '<iframe src="http://player.vimeo.com/video/' . get_post_meta(get_the_ID(), 'tf_embed', true) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="920" height="518" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                                } else if (get_post_meta(get_the_ID(), 'tf_source', true) == 'youtube') {
                                    echo '<iframe width="920" height="518" src="http://www.youtube.com/embed/' . get_post_meta(get_the_ID(), 'tf_embed', true) . '?rel=0&showinfo=0&modestbranding=1&hd=1&autohide=1&color=white" frameborder="0" allowfullscreen></iframe>';
                                } else {
                                    echo "Video embed code is missing";
                                }
                                ?>
                            </div>
                        <?php } ?>

                            <?php 
                            $hidecomments = get_theme_mod( 'tf_hide_comments', 'no' );
                            if ($hidecomments == 'no') {
                            }
                            else {
                                comments_template('', true); 
                            }
                            ?>                
                    </div>

                    <div id="showcasecontent" class="three_fourth first">

                        <h4><?php _e('Showcase Description', 'tfbasedetails'); ?></h4>

                        <?php the_content(); ?>
                    </div>
                    <div id="showcasedetails" class="one_fourth">
                        <h4><?php _e('Showcase Details', 'tfbasedetails'); ?></h4>
                        <?php the_time('F jS, Y') ?>
                        <div class="scwebsite clearfix">
                            <?php if ($website) { ?><a href="<?php echo $website; ?>"><i class="icon-external-link"></i>
                                <?php
                                if ($shdesc) {
                                    echo $shdesc;
                                } else {
                                    _e(' Visit Website', 'tfbasedetails');
                                }
                                ?>
                                </a><?php } ?>
                        </div>

                    </div>
                <?php endwhile;
            endif; ?>
            <div class="clearboth"></div>
        </div>
        <div class="clearboth"></div>
    </section>
    <?php get_footer(); ?>