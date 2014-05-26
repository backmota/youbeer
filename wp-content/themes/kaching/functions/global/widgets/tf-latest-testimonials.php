<?php
/* -----------------------------------------------------------------------------------

  Plugin Name: themesforge Latest Testimonials Widget
  Plugin URI: http://www.themesforge.com
  Description: A simple widget to display a testimonials.
  Version: 1.0
  Author: Ed Bloom
  Author URI: http://www.themesforge.com

  ----------------------------------------------------------------------------------- */
add_action( 'widgets_init', 'tf_reg_testimonials' );

function tf_reg_testimonials() {
	register_widget('tf_testimonials_Widget');
}						

class tf_testimonials_Widget extends WP_Widget {

	function tf_testimonials_Widget() {
        // Widget settings
        $widget_ops = array(
            'classname' => 'tf_testimonials_widget',
            'description' => __('A simple widget to display a your latest testimonials.', 'tfbasedetails')
        );

        // Widget control settings
        $control_ops = array(
            'width' => 300,
            'height' => 350,
            'id_base' => 'tf_testimonials_widget'
        );

        // Create the widget
        $this->WP_Widget('tf_testimonials_widget', __('TF - Latest Testimonials', 'tfbasedetails'), $widget_ops, $control_ops);		
	}


    function widget($args, $instance) {
        extract($args);
        $testimonialstitle = $instance['testimonialstitle'];
        $testimonialstitlestrapline = $instance['testimonialstitlestrapline'];
        $numposts = $instance['numposts'];

        //echo $before_widget;

        ?>
        <h2><?php echo $testimonialstitle; ?></h2>
        <span class="hp-test-intro"><?php echo $testimonialstitlestrapline ?></span>
        <?php
        $query_args = array('posts_per_page' => $numposts, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'tf_hptestimonial');

        $r = new WP_Query($query_args);

        if ($r->have_posts()) :
            ?>
                <?php while ($r->have_posts()) : $r->the_post(); ?>	
                <div class="hp-quote">
                    <div class="hp-quote-drop"></div>
                    <p><?php the_content(); ?></p>
                </div>
                <div class="hp-quote-meta">
                    <span class="hp-quote-author"><?php echo get_post_meta($r->post->ID, "hptestimonial_name", true);  ?></span>
                    -
                    <span class="hp-quote-bio"><?php echo get_post_meta($r->post->ID, "hptestimonial_occupation", true);  ?></span>
                </div>
                <?php wp_reset_query();
            	endwhile; ?>
        <?php endif; ?>

        <?php
        //echo $after_widget;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Update Widget
      /*----------------------------------------------------------------------------------- */

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['testimonialstitle'] = strip_tags($new_instance['testimonialstitle']);
        $instance['testimonialstitlestrapline'] = strip_tags($new_instance['testimonialstitlestrapline']);
        $instance['numposts'] = strip_tags($new_instance['numposts']);
        // No need to strip tags
        return $instance;
    }

    function form($instance) {

        // Set up some default widget settings
        $defaults = array(
            'testimonialstitle' => 'About our store',
            'testimonialstitlestrapline' => 'Do not listen to us. Let our customers tell you!',
            'numposts' => '2',
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('testimonialstitle'); ?>"><?php _e('Testimonial Widget Title:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('testimonialstitle'); ?>" name="<?php echo $this->get_field_name('testimonialstitle'); ?>" value="<?php echo $instance['testimonialstitle']; ?>" />
        </p>

        <!-- Button Text: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('testimonialstitlestrapline'); ?>"><?php _e('Testimonial Widget Strapline:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('testimonialstitlestrapline'); ?>" name="<?php echo $this->get_field_name('testimonialstitlestrapline'); ?>" value="<?php echo $instance['testimonialstitlestrapline']; ?>" />
        </p>

        <!-- Button Text: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('numposts'); ?>"><?php _e('Number of Testimonials to display:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('numposts'); ?>" name="<?php echo $this->get_field_name('numposts'); ?>" value="<?php echo $instance['numposts']; ?>" />
        </p>


        <?php
    }	
}	
?>
