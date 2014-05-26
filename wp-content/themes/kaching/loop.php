<?php
/**
 * The loop that displays posts.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>
<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if (!have_posts()) : ?>
    <article id="post-0" class="post error404 not-found">
        <h1 class="entry-title"><?php _e('Not Found', 'tfbasedetails'); ?></h1>
        <div class="entry-content">
            <p><?php _e('The page you trying to reach does not exist, or has been moved. Please use our menus and search facility to find what you were looking for.', 'tfbasedetails'); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
<?php endif; ?>

<?php /* Start the Loop.
 *
 * We use the same loop in multiple contexts.
 * It is broken into three main parts: when we're displaying
 * posts that are in the gallery category, when we're displaying
 * posts in the asides category, and finally all other posts.
 *
 * Additionally, we sometimes check for whether we are on an
 * archive page, a search page, etc., allowing for small differences
 * in the loop on each template without actually duplicating
 * the rest of the loop that is shared.
 *
 * Without further ado, the loop:
 */ ?>
<?php while (have_posts()) : the_post(); ?>

    <?php /* How to display posts in the Gallery category. */ ?>

    <?php if (in_category(_x('gallery', 'gallery category slug', 'tfbasedetails'))) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="entry-meta">
                <?php tfbasedetails_posted_on(); ?>
            </div><!-- .entry-meta -->
            <div class="entry-content">
                <?php if (post_password_required()) : ?>
                    <?php the_content(); ?>
                <?php else : ?>			
                    <?php
                    $images = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999));
                    if ($images) :
                        $total_images = count($images);
                        $image = array_shift($images);
                        $image_img_tag = wp_get_attachment_image($image->ID, 'thumbnail');
                        ?>
                        <div class="gallery-thumb">
                            <a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
                        </div><!-- .gallery-thumb -->
                        <p><em><?php
                printf(__('This gallery contains <a %1$s>%2$s photos</a>.', 'tfbasedetails'), 'href="' . get_permalink() . '" title="' . sprintf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')) . '" rel="bookmark"', $total_images
                );
                        ?></em></p>
                    <?php endif; ?>
                    <?php the_excerpt(); ?>
                <?php endif; ?>
            </div><!-- .entry-content -->

            <footer class="entry-utility">
                <a href="<?php echo get_term_link(_x('gallery', 'gallery category slug', 'tfbasedetails'), 'category'); ?>" title="<?php esc_attr_e('View posts in the Gallery category', 'tfbasedetails'); ?>"><?php _e('More Galleries', 'tfbasedetails'); ?></a>
                |
                <?php comments_popup_link(__('Leave a comment', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?>
                <?php edit_post_link(__('Edit', 'tfbasedetails'), '|', ''); ?>
            </footer><!-- .entry-utility -->
        </article><!-- #post-## -->

        <?php /* How to display posts in the asides category */ ?>

    <?php elseif (in_category(_x('asides', 'asides category slug', 'tfbasedetails'))) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php if (is_archive() || is_search()) : // Display excerpts for archives and search.  ?>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div><!-- .entry-summary -->
            <?php else : ?>
                <div class="entry-content">
                    <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'tfbasedetails')); ?>
                </div><!-- .entry-content -->
            <?php endif; ?>

            <footer class="entry-utility">
                <?php tfbasedetails_posted_on(); ?>
                |
                <?php comments_popup_link(__('Leave a comment', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?>
                <?php edit_post_link(__('Edit', 'tfbasedetails'), '| ', ''); ?>
            </footer><!-- .entry-utility -->
        </article><!-- #post-## -->

        <?php /* How to display all other posts. */ ?>

    <?php else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
            <header>
                <div class="post-thumb">
                    <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark">                
                        <?php the_post_thumbnail('pg-feat', array('class' => 'thumbnail')); ?></a>
                </div>

                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

                <div class="entry-meta">
                    <?php tfbasedetails_posted_on(); ?>
                    <div class="entry-fr">
                        <?php if (count(get_the_category())) : ?>
                            <?php printf(__('Posted in %2$s', 'tfbasedetails'), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list(', ')); ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .entry-meta -->
            </header>
            <div class="entry-content">
                <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'tfbasedetails')); ?>
                <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'tfbasedetails'), 'after' => '</div>')); ?>
            </div><!-- .entry-content -->

            <footer class="entry-utility">
                <?php
                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list):
                    ?>
                    <div class="posttags">
                        <i class="icon-tags"></i>
                        <?php printf(__('Tagged %2$s', 'tfbasedetails'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?>
                    </div>
                <?php endif; ?>
                <div class="postcomments">
                    <i class="icon-comments"></i>                                
                    <?php comments_popup_link(__('Leave a comment', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?> <?php edit_post_link(__('Edit', 'tfbasedetails'), '| ', ''); ?>
                </div>    
            </footer><!-- .entry-utility -->
        </article><!-- #post-## -->

        <?php comments_template('', true); ?>

    <?php endif; // This was the if statement that broke the loop into three parts based on categories.  ?>

<?php endwhile; // End the loop. Whew.  ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ($wp_query->max_num_pages > 1) : ?>
    <nav id="nav-below" class="navigation">
        <?php //next_posts_link(__('&larr; Older posts', 'tfbasedetails')); ?>
        <?php kriesi_pagination(); ?>
        <?php //previous_posts_link(__('Newer posts &rarr;', 'tfbasedetails')); ?>
    </nav><!-- #nav-below -->
<?php endif; ?>