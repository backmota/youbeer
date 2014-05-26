<?php
/**
 * The template for displaying attachments
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
                            <?php if (!empty($post->post_parent)) : ?>
                                <p class="page-title"><a href="<?php echo get_permalink($post->post_parent); ?>" title="<?php esc_attr(printf(__('Return to %s', 'tfbasedetails'), get_the_title($post->post_parent))); ?>" rel="gallery"><?php
                    /* translators: %s - title of parent post */
                    printf(__('<span class="meta-nav">&larr;</span> %s', 'tfbasedetails'), get_the_title($post->post_parent));
                                ?></a></p>
                            <?php endif; ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <h2 class="entry-title"><?php the_title(); ?></h2>
                                <div class="entry-meta">
                                    <?php
                                    printf(__('By %2$s', 'tfbasedetails'), 'meta-prep meta-prep-author', sprintf('<a class="url fn n" href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', 'tfbasedetails'), get_the_author()), get_the_author()
                                            )
                                    );
                                    ?>
                                    <span>|</span>
                                    <?php
                                    printf(__('Published %2$s', 'tfbasedetails'), 'meta-prep meta-prep-entry-date', sprintf('<abbr title="%1$s">%2$s</abbr>', esc_attr(get_the_time()), get_the_date()
                                            )
                                    );
                                    if (wp_attachment_is_image()) {
                                        echo ' | ';
                                        $metadata = wp_get_attachment_metadata();
                                        printf(__('Full size is %s pixels', 'tfbasedetails'), sprintf('<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>', wp_get_attachment_url(), esc_attr(__('Link to full-size image', 'tfbasedetails')), $metadata['width'], $metadata['height']
                                                )
                                        );
                                    }
                                    ?>
                                    <?php edit_post_link(__('Edit', 'tfbasedetails'), '', ''); ?>
                                </div><!-- .entry-meta -->
                                <div class="entry-content">
                                    <div class="entry-attachment">
                                        <?php
                                        if (wp_attachment_is_image()) :
                                            $attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));
                                            foreach ($attachments as $k => $attachment) {
                                                if ($attachment->ID == $post->ID)
                                                    break;
                                            }
                                            $k++;
                                            // If there is more than 1 image attachment in a gallery
                                            if (count($attachments) > 1) {
                                                if (isset($attachments[$k]))
                                                // get the URL of the next image attachment
                                                    $next_attachment_url = get_attachment_link($attachments[$k]->ID);
                                                else
                                                // or get the URL of the first image attachment
                                                    $next_attachment_url = get_attachment_link($attachments[0]->ID);
                                            } else {
                                                // or, if there's only 1 image attachment, get the URL of the image
                                                $next_attachment_url = wp_get_attachment_url();
                                            }
                                            ?>
                                            <p><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment"><?php
                                $attachment_size = apply_filters('tfbasedetails_attachment_size', 900);
                                echo wp_get_attachment_image($post->ID, array($attachment_size, 9999)); // filterable image width with, essentially, no limit for image height.
                                            ?></a></p>
                                            <nav id="nav-below" class="navigation">
                                                <div class="nav-previous"><?php previous_image_link(false); ?></div>
                                                <div class="nav-next"><?php next_image_link(false); ?></div>
                                            </nav><!-- #nav-below -->
                                        <?php else : ?>
                                            <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment"><?php echo basename(get_permalink()); ?></a>
                                        <?php endif; ?>
                                    </div><!-- .entry-attachment -->
                                    <div class="entry-caption"><?php if (!empty($post->post_excerpt))
                                    the_excerpt(); ?></div>
                                    <?php the_content(__('Continue reading &rarr;', 'tfbasedetails')); ?>
                                    <?php wp_link_pages(array('before' => '' . __('Pages:', 'tfbasedetails'), 'after' => '')); ?>
                                    <footer class="entry-utility">
                                        <?php tfbasedetails_posted_in(); ?>
                                        <?php edit_post_link(__('Edit', 'tfbasedetails'), ' <span class="edit-link">', '</span>'); ?>
                                    </footer><!-- .entry-utility -->                                            
                                    <?php 
                                    $hidecomments = get_theme_mod( 'tf_hide_comments', 'no' );
                                    if ($hidecomments == 'no') {
                                    }
                                    else {
                                        comments_template('', true); 
                                    }
                                    ?>
                                </div><!-- .entry-content -->
                            </article>
                        <?php endwhile; ?>
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