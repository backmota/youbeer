<?php
/* -----------------------------------------------------------------------------------

  Plugin Name: themesforge Store Promo Widget
  Plugin URI: http://www.themesforge.com
  Description: A simple widget to display a promo message on your WooCommerce store.
  Version: 1.0
  Author: Ed Bloom
  Author URI: http://www.themesforge.com

  ----------------------------------------------------------------------------------- */
add_action( 'widgets_init', 'tf_reg_store_promo' );

function tf_reg_store_promo() {
	register_widget('tf_storepromo_Widget');
}						

class tf_storepromo_Widget extends WP_Widget {

	function tf_storepromo_Widget() {
        // Widget settings
        $widget_ops = array(
            'classname' => 'tf_storepromo_widget',
            'description' => __('A simple widget to display a promo message on your WooCommerce store.', 'tfbasedetails')
        );

        // Widget control settings
        $control_ops = array(
            'width' => 300,
            'height' => 350,
            'id_base' => 'tf_storepromo_widget'
        );

        // Create the widget
        $this->WP_Widget('tf_storepromo_widget', __('TF - Store Promo Widget', 'tfbasedetails'), $widget_ops, $control_ops);		
	}


    function widget($args, $instance) {
        extract($args);
        $offertitle = $instance['offertitle'];
        $buttontext = $instance['buttontext'];
        $offerlink = $instance['offerlink'];

        echo $before_widget;

        ?>

		<a href="<?php echo $offerlink ?>">
            <div class="hp-offer">
                        <h3 class="hp-offer-title"><?php echo $offertitle ?><span class="hp-offer-more"><?php echo $buttontext ?></span></h3><h3></h3>
            </div>
        </a>

        <?php
        echo $after_widget;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Update Widget
      /*----------------------------------------------------------------------------------- */

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['offertitle'] = strip_tags($new_instance['offertitle']);
        $instance['buttontext'] = strip_tags($new_instance['buttontext']);
        // No need to strip tags
        $instance['offerlink'] = $new_instance['offerlink'];
        return $instance;
    }

    function form($instance) {

        // Set up some default widget settings
        $defaults = array(
            'offertitle' => 'Get 10% of all orders placed online!',
            'buttontext' => 'Find Out More',
            'offerlink' => 'http://themesforge.com',
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('offertitle'); ?>"><?php _e('Offer Text:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('offertitle'); ?>" name="<?php echo $this->get_field_name('offertitle'); ?>" value="<?php echo $instance['offertitle']; ?>" />
        </p>

        <!-- Button Text: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('buttontext'); ?>"><?php _e('Button Text:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('buttontext'); ?>" name="<?php echo $this->get_field_name('buttontext'); ?>" value="<?php echo $instance['buttontext']; ?>" />
        </p>

        <!-- Link: Link Input -->
        <p>
            <label for="<?php echo $this->get_field_id('offerlink'); ?>"><?php _e('Offer Link:', 'tfbasedetails') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('offerlink'); ?>" name="<?php echo $this->get_field_name('offerlink'); ?>" value="<?php echo $instance['offerlink']; ?>" />
        </p>

        <?php
    }	
}	
?>
