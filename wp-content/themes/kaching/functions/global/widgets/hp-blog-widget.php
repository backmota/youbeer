<?php
/* -----------------------------------------------------------------------------------
  Credits for original Custom Blog Widget from Orman Clark at http://www.premiumpixels.com
  Plugin Name: Custom Blog Widget
  Plugin URI: http://www.premiumpixels.com
  Description: A widget that allows the display of blog posts.
  Version: 1.0
  Author: Orman Clark
  Author URI: http://www.premiumpixels.com

  ----------------------------------------------------------------------------------- */


// Add function to widgets_init that'll load our widget.
add_action('widgets_init', 'tf_blog_widgets');

// Register widget.
function tf_blog_widgets() {
    register_widget('TF_Blog_Widget');
}

// Widget class.
class tf_blog_widget extends WP_Widget {
    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Setup
      /*----------------------------------------------------------------------------------- */

    function TF_Blog_Widget() {

        /* Widget settings. */
        $widget_ops = array('classname' => 'tf_blog_widget', 'description' => __('A widget that displays your latest posts with image.', 'tfbasedetails'));

        /* Widget control settings. */
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'tf_blog_widget');

        /* Create the widget. */
        $this->WP_Widget('tf_blog_widget', __('TF - Custom Blog Widget', 'tfbasedetails'), $widget_ops, $control_ops);
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Display Widget
      /*----------------------------------------------------------------------------------- */

    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);

        /* Our variables from the widget settings. */
        $number = $instance['number'];

        $description = $instance['desc'];


        /* Before widget (defined by themes). */
        echo $before_widget;

        /* Display Widget */
        ?>
        <?php
        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title)
            echo $before_title . $title . $after_title;
        ?>

        <span class="hp-test-intro"><?php echo $description; ?></span>

        <div class="tf-blog-widget">

            <ul class="clearfix">

                <?php
                $args = array(
                    'posts_per_page' => $number,
                    'ignore_sticky_posts' => 1
                );

                $query = new WP_Query($args);

                //$query->query('posts_per_page' => $number, 'ignore_sticky_posts' => 1);
                ?>
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                        <li class="tfblogitem clearfix">
                            <?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : /* if post has post thumbnail */ ?>
                                <div class="post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('tiny-post-thumbnail'); ?></a></div><!--image-->
                            <?php endif; ?>
                            <div class="detail clearfix">

                                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <span class="entry-meta"><?php the_time(get_option('date_format')); ?>, <?php comments_popup_link(__('No comments', 'tfbasedetails'), __('1 Comment', 'tfbasedetails'), __('% Comments', 'tfbasedetails')); ?></span>
                            </div>
                        </li>
                    <?php endwhile;
                endif; ?>

                <?php wp_reset_query(); ?>

            </ul>

        </div><!--blog_widget-->

        <?php
        /* After widget (defined by themes). */
        echo $after_widget;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Update Widget
      /*----------------------------------------------------------------------------------- */

    function update($new_instance, $old_instance) {

        $instance = $old_instance;

        /* Strip tags to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        $instance['number'] = strip_tags($new_instance['number']);

        /* No need to strip tags for.. */

        return $instance;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Settings
      /*----------------------------------------------------------------------------------- */

    function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array(
            'title' => 'Kaching in the news.',
            'desc' => 'The latest stories from our blog',
            'number' => 4
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tfbasedetails') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Description:', 'tfbasedetails') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" value="<?php echo $instance['desc']; ?>" />
        </p>
        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Amount to show:', 'tfbasedetails') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
        </p>


        <?php
    }

}
?>