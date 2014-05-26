<?php
/**
 * The template for displaying Comments. Major kudos to twentyeleven for the basis for this code.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyeleven_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>
<div id="comments">
    <?php if (post_password_required()) : ?>
        <p class="nocomments"><?php _e('This post is password protected. Enter the password to view any comments.', 'tfbasedetails'); ?></p>
    </div><!-- #comments -->
    <?php
    /* Stop the rest of comments.php from being processed,
     * but don't kill the script entirely -- we still have
     * to fully load the template.
     */
    return;
endif;
?>

<?php // You can start editing here -- including this comment! ?>

<?php if (have_comments()) : ?>
    <h3 id="comments-title"><i class="icon-comments"></i>
        <?php
        printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'tfbasedetails'), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
        ?>
    </h3>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through  ?>
        <nav id="comment-nav-above" class="clearfix">
            <h1 class="assistive-text"><?php _e('Comment navigation', 'tfbasedetails'); ?></h1>
            <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'tfbasedetails')); ?></div>
            <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'tfbasedetails')); ?></div>
        </nav>
    <?php endif; // check for comment navigation  ?>

    <ol class="commentlist">
        <?php
        /* Loop through and list the comments. Tell wp_list_comments()
         * to use twentyeleven_comment() to format the comments.
         * If you want to overload this in a child theme then you can
         * define twentyeleven_comment() and that will be used instead.
         * See twentyeleven_comment() in twentyeleven/functions.php for more.
         */
        wp_list_comments(array('callback' => 'tfbasedetails_comment'));
        ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through  ?>
        <nav id="comment-nav-below" class="clearfix">
            <h1 class="assistive-text"><?php _e('Comment navigation', 'tfbasedetails'); ?></h1>
            <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'tfbasedetails')); ?></div>
            <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'tfbasedetails')); ?></div>
        </nav>
    <?php endif; // check for comment navigation  ?>

    <?php
/* If there are no comments and comments are closed, let's leave a little note, shall we?
 * But we don't want the note on pages or post types that do not support comments.
 */
elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <p class="nocomments"><?php _e('Comments are closed.', 'tfbasedetails'); ?></p>
<?php endif; ?>

<?php
comment_form(
        array(
            'cancel_reply_link' => __('Cancel reply', 'tfbasedetails'),
            'label_submit' => __('Post Comment', 'tfbasedetails'),
            'fields' => array(
                'author' => '<p class="comment-form-author">' . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="22" />' . '<label for="author"><small>' . __('Name', 'tfbasedetails') . '</small></label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
                'email' => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" /><label for="email"><small>' . __('Email', 'tfbasedetails') . '</small></label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
                'url' => '<p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="22" /><label for="url"><small>' . __('Website', 'tfbasedetails') . '</small></label>' . '</p>',
            ),
            'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" style="width:97%;"></textarea></p>',
        )
);
?>

</div><!-- #comments -->
