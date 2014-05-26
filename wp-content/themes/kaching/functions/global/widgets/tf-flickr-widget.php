<?php
/* -----------------------------------------------------------------------------------

  Plugin Name: Custom Flickr Widget
  Plugin URI: http://www.themesforge.com
  Description: Yet another Flickr widget to display Flickr goodies
  Version: 1.0
  Author: Ed Bloom
  Author URI: http://www.themesforge.com
  Credits: Orman Clark at http://www.premiumpixels.com and WooThemes for laying the groundwork for this widget.

  ----------------------------------------------------------------------------------- */


// Init the widget
add_action('widgets_init', 'tf_flickr_widgets');

// Register widget
function tf_flickr_widgets() {
    register_widget('tf_flickr_Widget');
}

// Widget class
class tf_flickr_widget extends WP_Widget {
    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Setup
      /*----------------------------------------------------------------------------------- */

    function tf_flickr_Widget() {

        // Widget settings
        $widget_ops = array(
            'classname' => 'tf_flickr_widget',
            'description' => __('A widget that displays your Flickr photos.', 'tfbasedetails')
        );

        // Widget control settings
        $control_ops = array(
            'width' => 300,
            'height' => 350,
            'id_base' => 'tf_flickr_widget'
        );

        // Create the widget
        $this->WP_Widget('tf_flickr_widget', __('TF - Flickr Widget', 'tfbasedetails'), $widget_ops, $control_ops);
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Frontend Output
      /*----------------------------------------------------------------------------------- */

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $flickrID = $instance['flickrID'];
        $postcount = $instance['postcount'];
        $type = $instance['type'];
        $display = $instance['display'];

        echo $before_widget;

        if ($title)
            echo $before_title . $title . $after_title;
        ?>

        <div id="flickr_badge_wrapper" class="clearfix">

            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>

        </div>

        <?php
        echo $after_widget;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Update Widget
      /*----------------------------------------------------------------------------------- */

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['flickrID'] = strip_tags($new_instance['flickrID']);

        // No need to strip tags
        $instance['postcount'] = $new_instance['postcount'];
        $instance['type'] = $new_instance['type'];
        $instance['display'] = $new_instance['display'];

        return $instance;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Settings (Displays the widget settings controls on the widget panel)
      /*----------------------------------------------------------------------------------- */

    function form($instance) {

        // Set up some default widget settings
        $defaults = array(
            'title' => 'My Flickr Photos',
            'flickrID' => '74532486@N00',
            'postcount' => '4',
            'type' => 'user',
            'display' => 'latest',
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <!-- Flickr ID: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('flickrID'); ?>"><?php _e('Flickr ID:', 'tfbasedetails') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('flickrID'); ?>" name="<?php echo $this->get_field_name('flickrID'); ?>" value="<?php echo $instance['flickrID']; ?>" />
        </p>

        <!-- Postcount: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('postcount'); ?>"><?php _e('Number of Photos to display:', 'tfbasedetails') ?></label>
            <select id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" class="widefat">
                <option <?php if ('4' == $instance['postcount'])
            echo 'selected="selected"'; ?>>4</option>
                <option <?php if ('8' == $instance['postcount'])
                echo 'selected="selected"'; ?>>8</option>
            </select>
        </p>

        <!-- Type: Select Box -->
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type (user or group):', 'tfbasedetails') ?></label>
            <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" class="widefat">
                <option <?php if ('user' == $instance['type'])
                echo 'selected="selected"'; ?>>user</option>
                <option <?php if ('group' == $instance['type'])
                echo 'selected="selected"'; ?>>group</option>
            </select>
        </p>

        <!-- Display: Select Box -->
        <p>
            <label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Display (random or latest):', 'tfbasedetails') ?></label>
            <select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>" class="widefat">
                <option <?php if ('random' == $instance['display'])
                echo 'selected="selected"'; ?>>random</option>
                <option <?php if ('latest' == $instance['display'])
                echo 'selected="selected"'; ?>>latest</option>
            </select>
        </p>

        <?php
    }

}
?>