<?php
/**
 * The template for displaying 404 errors
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
                <h1>Oops!</h1>
            </div>
            <div class="content generic nine alpha units">
                <div id="content">
                    <article id="post-0" class="post error404 not-found" role="main">
                        <h1><?php _e('Not Found', 'tfbasedetails'); ?></h1>
                        <p><?php _e('The page you trying to reach does not exist, or has been moved. Please use our menus and search facility to find what you were looking for.', 'tfbasedetails'); ?></p>
                        <script>
                            // focus on search field after it has loaded
                            document.getElementById('s') && document.getElementById('s').focus();
                        </script>
                    </article>
                    <div class="clearboth"></div>
                </div>
            </div>
            <aside id="sidebar-right" class="units three">
                <div id="sidebar_content" class="lessgap sidebar sidebar_right">
                    <?php get_sidebar(); ?>
                </div>

                <div id="sidebar_bottom"></div>
            </aside>
        </div>

        <div class="clearboth"></div>
    </section>
    <?php get_footer(); ?>
