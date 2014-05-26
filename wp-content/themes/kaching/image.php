<?php
/**
 * The template for displaying image attachments.
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
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <div class="thecontent">
                                <?php
                                /**
                                 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
                                 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
                                 */
                                $attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));
                                foreach ($attachments as $k => $attachment) {
                                    if ($attachment->ID == $post->ID)
                                        break;
                                }
                                $k++;
                                // If there is more than 1 attachment in a gallery
                                if (count($attachments) > 1) {
                                    if (isset($attachments[$k]))
                                    // get the URL of the next image attachment
                                        $next_attachment_url = get_attachment_link($attachments[$k]->ID);
                                    else
                                    // or get the URL of the first image attachment
                                        $next_attachment_url = get_attachment_link($attachments[0]->ID);
                                } else {
                                    // or, if there's only 1 image, get the URL of the image
                                    $next_attachment_url = wp_get_attachment_url();
                                }
                                ?>
                                <nav id="nav-single" class="clearfix">
                                    <h3 class="assistive-text"><?php _e('Image navigation', 'tfbasedetails'); ?></h3>
                                    <span class="nav-previous"><?php previous_image_link(false, __('&larr; Previous', 'tfbasedetails')); ?></span>
                                    <span class="nav-next"><?php next_image_link(false, __('Next &rarr;', 'tfbasedetails')); ?></span>
                                </nav><!-- #nav-single -->
                                <div class="imgctr">
                                    <a href="<?php echo esc_url($next_attachment_url); ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment"><?php
                                $attachment_size = apply_filters('tfbasedetails_attachment_size', 848);
                                echo wp_get_attachment_image($post->ID, array($attachment_size, 1024)); // filterable image width with 1024px limit for image height.
                                ?></a>
                                </div>
                            </div>
                        </div><!-- .entry-content -->
                    </article><!-- #post-## -->

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