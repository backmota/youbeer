<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>

<?php if (is_sticky()) : ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('article-sticky clearfix'); ?>>
    <?php else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
        <?php endif; ?>     

        <div class="post-thumb">
            <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark">                
                <?php the_post_thumbnail('pg-feat', array('class' => 'thumbnail')); ?></a>
        </div>
        <header class="entry-header">
            <?php if (is_sticky()) : ?>
                <hgroup>
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <h3 class="entry-format featured"><?php _e('Featured', 'tfbasedetails'); ?></h3>
                </hgroup>
            <?php else : ?>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php endif; ?>          
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

        <div class="entry-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'tfbasedetails')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'tfbasedetails'), 'after' => '</div>')); ?>
        </div><!-- .entry-content -->

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
                <?php endif; // End if $tags_list  ?>
            <?php endif; // End if 'post' == get_post_type()  ?>

            <div class="postcomments">
                <i class="icon-comments"></i>                                
                <?php comments_popup_link(__('Leave a comment', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?> <?php edit_post_link(__('Edit', 'tfbasedetails'), '| ', ''); ?>
            </div> 
        </footer><!-- #entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
