<?php
/**
 * The Template for displaying all single posts.
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
                                <div class="post-thumb">
                                    <?php the_post_thumbnail('blog-single', array('class' => 'thumbnail')); ?>
                                </div>
                                <div class="entry-meta">
                                    <?php tfbasedetails_posted_on(); ?>
                                    <?php if (count(get_the_category())) : ?>
                                        <div class="entry-fr">
                                            <?php printf(__('Posted in %2$s', 'tfbasedetails'), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list(', ')); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="entry-content">
                                    <?php the_content(); ?><?php wp_link_pages(array('before' => '' . __('Pages:', 'tfbasedetails'), 'after' => '')); ?>
                                    <?php
                                    $tags_list = get_the_tag_list('', ', ');
                                    if ($tags_list):
                                        ?>
                                        <div class="posttags-single">
                                            <i class="icon-tags"></i>
                                            <?php printf(__('Tagged %2$s', 'tfbasedetails'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?>
                                        </div>
                                    <?php endif; ?></div>
                                <?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries    ?>
                                    <footer id="post-author">
                                        <div class="profile-image">
                                            <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('boilerplate_author_bio_avatar_size', 60)); ?>
                                        </div>
                                        <div class="profile-content">
                                            <h2 class="authortitle"><?php printf(esc_attr__('About %s', 'tfbasedetails'), get_the_author()); ?></h2><?php the_author_meta('description'); ?>
                                            <div class="profile-link">
                                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php printf(__('View all posts by %s &rarr;', 'tfbasedetails'), get_the_author()); ?></a>
                                            </div>
                                        </div>
                                    </footer>
                                <?php endif; ?>
                            </article>
                            <div class="clearboth"></div>
                            <?php 
                                comments_template('', true); 
                            ?>
                        <?php endwhile; // end of the loop.       ?>
                </div>
            </div>
           
        </div>
        <div class="clearboth"></div>
    </section>
    <?php get_footer(); ?>
