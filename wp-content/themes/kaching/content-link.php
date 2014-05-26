<?php
/**
 * The template for displaying posts in the Link Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article-link clearfix'); ?>>
    <header class="entry-header">
        <hgroup>
            <h2 class="entry-title"><a href="<?php echo tfbasedetails_url_grabber(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <h3 class="entry-format link"><?php _e('Link', 'tfbasedetails'); ?></h3>
        </hgroup>
    </header><!-- .entry-header -->

    <?php if (is_search()) : // Only display Excerpts for Search  ?>
        <div class="post-thumb">
            <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'tfbasedetails'), the_title_attribute('echo=0')); ?>" rel="bookmark">                
                <?php the_post_thumbnail('pg-feat', array('class' => 'thumbnail')); ?></a>
        </div>

        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content link-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'tfbasedetails')); ?>
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
            <?php endif; // End if $tags_list  ?>
        <?php endif; // End if 'post' == get_post_type()  ?>

        <div class="postcomments">     
        <i class="icon-comments"></i>                           
            <?php comments_popup_link(__('Leave a comment', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?> <?php edit_post_link(__('Edit', 'tfbasedetails'), '| ', ''); ?>
        </div> 
    </footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
