<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-gallery clearfix'); ?>>
    <header class="entry-header">
        <hgroup>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <h3 class="entry-format gallery"><?php _e('Gallery', 'tfbasedetails'); ?></h3>
        </hgroup>
        <?php if ('post' == get_post_type()) : ?>
            <div class="entry-meta">
                <?php tfbasedetails_posted_on(); ?>
                <?php
                $categories_list = get_the_category_list(__(', ', 'tfbasedetails'));
                if ($categories_list):
                    ?>

                    <div class="entry-fr">
                        <?php printf(__('<span class="%1$s">Posted in</span> %2$s', 'tfbasedetails'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list);
                        $show_sep = true; ?>
                    </div>
                <?php endif; // End if categories ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php if (is_search()) : // Only display Excerpts for Search  ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content gallery-content">
            <?php if (post_password_required()) : ?>
                <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'tfbasedetails')); ?>

            <?php else : ?>


                <?php
                $images = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999));
                if ($images) :
                    $total_images = count($images);
                    $image = array_shift($images);
                    $image_img_tag = wp_get_attachment_image($image->ID, 'thumbnail');
                    ?>

                    <figure class="gallery-thumb">
                        <a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
                    </figure><!-- .gallery-thumb -->
                    <?php the_excerpt(); ?>
                    <p><em><?php
            printf(_n('This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'tfbasedetails'), 'href="' . esc_url(get_permalink()) . '" title="' . sprintf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')) . '" rel="bookmark"', number_format_i18n($total_images)
            );
                    ?></em></p>
                <?php endif; ?>

            <?php endif; ?>
            <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'tfbasedetails'), 'after' => '</div>')); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-utility">
        <?php
        if ('post' == get_post_type()) : // Hide category and tag text for pages on Search

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', __(', ', 'tfbasedetails'));
            if ($tags_list):
                ?>
                <div class="posttags">
                    <i class="icon-tags"></i>
                    <?php printf(__('Tagged %2$s', 'tfbasedetails'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?>
                </div>
            <?php endif; // End if $tags_list   ?>
        <?php endif; // End if 'post' == get_post_type()    ?>

        <div class="postcomments">                                
        <i class="icon-comments"></i>
            <?php comments_popup_link(__('Leave a comment', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?> <?php edit_post_link(__('Edit', 'tfbasedetails'), '| ', ''); ?>
        </div> 
    </footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
