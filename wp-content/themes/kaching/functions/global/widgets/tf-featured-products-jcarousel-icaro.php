<?php
/**
 * Featured Products Widget - modified for jcarousel
 *
 * Gets and displays featured products in an unordered list
 * 
 * @package	WooCommerce
 * @category	Widgetss
 * @author	Ed Bloom - themesforge.com (Original by Woothemes)
 */
// Add function to widgets_init that'll load our widget.
add_action('widgets_init', 'tf_jcarousel_featured_products_widget_2');

remove_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
remove_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);

// Register widget.
function tf_jcarousel_featured_products_widget_2() {
    register_widget('WooCommerce_JCarousel_Widget_Featured_Products_2');
}

class WooCommerce_JCarousel_Widget_Featured_Products_2 extends WP_Widget {

    /** Variables to setup the widget. */
    var $woo_widget_cssclass;
    var $woo_widget_description;
    var $woo_widget_idbase;
    var $woo_widget_name;

    /** constructor */
    function WooCommerce_JCarousel_Widget_Featured_Products_2() {

        /* Widget variable settings. */
        $this->woo_widget_cssclass = 'widget_jcarousel_featured_products_2';
        $this->woo_widget_description = __('Display a list of featured products on your site - enhanced for jCarousel.', 'tfbasedetails');
        $this->woo_widget_idbase = 'woocommerce_featured_products_2';
        $this->woo_widget_name = __('TF - JCarousel Featured Products', 'tfbasedetails');

        /* Widget settings. */
        $widget_ops = array('classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description);

        /* Create the widget. */
        $this->WP_Widget('jcarousel_featured_products_2', $this->woo_widget_name, $widget_ops);

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('deleted_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    /** @see WP_Widget */
    function widget($args, $instance) {
        global $woocommerce;

        $cache = wp_cache_get('jcarousel_widget_featured_products_2', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Featured Products', 'tfbasedetails') : $instance['title'], $instance, $this->id_base);
        $desc = apply_filters('widget_desc', empty($instance['desc']) ? __('A wonderful description', 'tfbasedetails') : $instance['desc'], $instance, $this->id_base);

        if (!$number = (int) $instance['number'])
            $number = 10;
        else if ($number < 1)
            $number = 1;
        else if ($number > 15)
            $number = 15;
        ?>

        <?php
        $query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'meta_key' => '_featured', 'meta_value' => 'yes');

        $r = new WP_Query($query_args);

        if ($r->have_posts()) :
            ?>

            <div class="widgethead">
            <?php if ($title)
                echo $before_title; ?><i class="icon-fire"></i><?php echo $title; ?> <small class="hpfeatstrap"><?php echo $desc; ?></small><?php echo $after_title; ?>
            </div>
            <?php //echo $before_widget; ?>
            <div id="feature1" class="jcarousel-container clearfix">
                <div class="jcarousel-clip">
                    <ul class="products products-carousel">
                            <?php while ($r->have_posts()) : $r->the_post();
                                global $product; ?>	
                                <li class="product">

                                    <?php do_action('woocommerce_before_shop_loop_item'); ?>

                                    <div class="tf_prodthumb">
                                        <div class="tf_prodthumb_inner">
                                    
                                    <a href="<?php the_permalink(); ?>">
                                        
                                        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>

                                    </a>

                                        </div>
                                    </div>

                                    <a href="<?php the_permalink(); ?>">

                                        <h3><?php the_title(); ?></h3>
                                        
                                        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
                                    
                                    <?php do_action('woocommerce_after_shop_loop_item'); ?>
                                    
                                    </a>
                                </li>
                <?php endwhile; ?>
                        </ul>
                </div>
            </div>
            <?php //echo $after_widget; ?>

            <?php
        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('jcarousel_widget_featured_products_2', $cache, 'widget');
    }

    /** @see WP_Widget->update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['jcarousel_widget_featured_products_2']))
            delete_option('jcarousel_widget_featured_products_2');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('jcarousel_widget_featured_products_2', 'widget');
    }

    /** @see WP_Widget->form */
    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $desc = isset($instance['desc']) ? esc_attr($instance['desc']) : '';
        if (!isset($instance['number']) || !$number = (int) $instance['number'])
            $number = 2;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tfbasedetails'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Description:', 'tfbasedetails'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('desc')); ?>" name="<?php echo esc_attr($this->get_field_name('desc')); ?>" type="text" value="<?php echo esc_attr($desc); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of products to show:', 'tfbasedetails'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
        <?php
    }

}

// class WooCommerce_Widget_Featured_Products