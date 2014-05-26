<?php
/**
 * The template for displaying Search Results pages.
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
                <h1>
                    <?php if (have_posts())
                        the_post(); ?>
                    <?php printf(__('Author Archives for: %s', 'tfbasedetails'), "<a class='url fn n' href='" . get_author_posts_url(get_the_author_meta('ID')) . "' title='" . esc_attr(get_the_author()) . "' rel='me'>" . get_the_author() . "</a>"); ?>
                </h1>
            </div>
            <div class="content generic nine alpha units">
                <div id="content">
                    <?php
                    if (have_posts())
                        the_post();
                    ?>

                    <?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries   ?>

                        <footer id="post-author">
                            <div class="profile-image">
                                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('tfbasedetails_author_bio_avatar_size', 60)); ?>
                            </div>

                            <div class="profile-content">
                                <h2 class="authortitle"><?php printf(esc_attr__('About %s', 'tfbasedetails'), get_the_author()); ?></h2><?php the_author_meta('description'); ?>

                            </div>
                        </footer><!-- #entry-author-info -->
                    <?php endif; ?>

                    <?php
                    /* Since we called the_post() above, we need to
                     * rewind the loop back to the beginning that way
                     * we can run the loop properly, in full.
                     */
                    rewind_posts();

                    /* Run the loop for the author archive page to output the authors posts
                     * If you want to overload this in a child theme then include a file
                     * called loop-author.php and that will be used instead.
                     */
                    get_template_part('loop', 'author');
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
    <?php get_footer(); ?>